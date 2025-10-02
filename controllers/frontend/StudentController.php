<?php
class StudentController {

    private static function response($status, $message = "", $data = []) {
        echo json_encode([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
        exit;
    }

    // CREATE a student and update total_stu in classes
    public static function createStu($conn, $fullname, $gender, $tel, $instructor_id, $class_id) {
        if (empty($fullname) || empty($gender)) {
            self::response(false, "Full name and gender are required");
        }

        $conn->begin_transaction();

        try {
            // Insert student
            $stmt = $conn->prepare("
                INSERT INTO students (full_name, gender, tel, instructor_id, class_id, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

            $stmt->bind_param("sssii", $fullname, $gender, $tel, $instructor_id, $class_id);

            if (!$stmt->execute()) throw new Exception("Insert student failed: " . $stmt->error);

            $studentId = $stmt->insert_id;

            // Update total_stu in classes
            $update = $conn->prepare("
                UPDATE classes
                SET total_stu = total_stu + 1
                WHERE id = ?
            ");
            if (!$update) throw new Exception("Prepare update failed: " . $conn->error);

            $update->bind_param("i", $class_id);
            if (!$update->execute()) throw new Exception("Update total_stu failed: " . $update->error);

            $conn->commit();
            self::response(true, "Student created successfully", ["id" => $studentId]);

        } catch (Exception $e) {
            $conn->rollback();
            self::response(false, $e->getMessage());
        }
    }

    public static function getStudentsByClass($conn, $class_id, $instructor_id) {
        if (empty($class_id) || empty($instructor_id)) {
            self::response(false, "Class ID and Instructor ID are required");
        }

        try {
            $stmt = $conn->prepare("
                SELECT id AS stu_id, full_name, gender, tel, class_id, instructor_id,
                    att_score, act_score, exam_score, total, passorfail
                FROM students
                WHERE class_id = ? AND instructor_id = ?
                ORDER BY full_name ASC
            ");
            $stmt->bind_param("ii", $class_id, $instructor_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $students = [];
            while ($row = $result->fetch_assoc()) {
                // Default attendance values if no record yet
                $row['present'] = 0;
                $row['absent'] = 0;
                $row['permission'] = 0;
                $row['reason'] = '';
                $students[] = $row;
            }

            self::response(true, "Students fetched successfully", $students);

        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }


   // Record attendance in batch and update att_score
    public static function recordsAttBatch($conn, $students, $class_id) {
        if (empty($students) || !is_array($students)) {
            self::response(false, "No student data provided");
        }

        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare("
                INSERT INTO student_records 
                (stu_id, present, absent, permission, reason, class_id) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

            $updateStmt = $conn->prepare("
                UPDATE students
                SET att_score = att_score - ?
                WHERE id = ?
            ");
            if (!$updateStmt) throw new Exception("Prepare update failed: " . $conn->error);

            foreach ($students as $stu) {
                $stu_id = $stu['stu_id'] ?? null;
                $present = $stu['present'] ?? 0;
                $absent = $stu['absent'] ?? 0;
                $permission = $stu['permission'] ?? 0;
                $reason = $stu['reason'] ?? "";
                
                if (!$stu_id) continue;

                // Insert attendance record
                $stmt->bind_param(
                    "iiiisi",
                    $stu_id,
                    $present,
                    $absent,
                    $permission,
                    $reason,
                    $class_id
                );
                if (!$stmt->execute()) throw new Exception("Insert failed for student $stu_id: " . $stmt->error);

                // Calculate deduction
                $deduction = ($absent * 1) + ($permission * 0.5);

                // Update att_score if deduction > 0
                if ($deduction > 0) {
                    $updateStmt->bind_param("di", $deduction, $stu_id);
                    if (!$updateStmt->execute()) throw new Exception("Failed to update att_score for student $stu_id: " . $updateStmt->error);
                }
            }

            $conn->commit();
            self::response(true, "Attendance recorded and att_score updated successfully");

        } catch (Exception $e) {
            $conn->rollback();
            self::response(false, $e->getMessage());
        }
    }


    // Check if attendance is recorded for today
    public static function isAttendanceRecordedToday($conn, $class_id, $date) {
        if (empty($class_id) || empty($date)) {
            self::response(false, "Class ID and date are required");
        }

        try {
            $stmt = $conn->prepare("
                SELECT COUNT(*) AS total
                FROM student_records sr
                INNER JOIN students s ON sr.stu_id = s.id
                WHERE s.class_id = ? AND DATE(sr.att_record_date) = ?
            ");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

            $stmt->bind_param("is", $class_id, $date);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!empty($row['total']) && $row['total'] > 0) {
                self::response(false, "⚠️ Attendance for today has already been recorded. Please wait for tomorrow.");
            } else {
                self::response(true, "✅ Attendance not yet recorded for today.");
            }

        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }

    // Fetch students along with their latest attendance (left join)
    public static function getStudentsWithAttendance($conn, $class_id) {
        try {
            $stmt = $conn->prepare("
                SELECT s.id AS stu_id, s.full_name, s.gender, s.tel,
                       sr.present, sr.absent, sr.permission, sr.reason,
                       sr.activity_score, sr.exam_score, sr.att_record_date
                FROM students s
                LEFT JOIN student_records sr
                ON s.id = sr.stu_id AND sr.class_id = ?
                WHERE s.class_id = ?
                ORDER BY s.full_name ASC
            ");
            $stmt->bind_param("ii", $class_id, $class_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            self::response(true, "Students with attendance fetched successfully", $data);

        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }

    // Fetch students with their attendance summary
    public static function getStudentsAttendanceSummary($conn, $class_id) {
        if (empty($class_id)) {
            self::response(false, "Class ID is required");
        }

        try {
            $stmt = $conn->prepare("
                SELECT s.id AS stu_id, s.full_name, s.gender, s.tel,
                    COALESCE(SUM(sr.present), 0) AS present,
                    COALESCE(SUM(sr.absent), 0) AS absent,
                    COALESCE(SUM(sr.permission), 0) AS permission
                FROM students s
                LEFT JOIN student_records sr ON s.id = sr.stu_id AND s.class_id = sr.class_id
                WHERE s.class_id = ?
                GROUP BY s.id
                ORDER BY s.full_name ASC
            ");

            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $students = [];
            while ($row = $result->fetch_assoc()) {
                // If student has no attendance, present/absent/permission = 0
                // $row['present'] = $row['present'] ?? 0;
                // $row['absent'] = $row['absent'] ?? 0;
                // $row['permission'] = $row['permission'] ?? 0;

                $students[] = $row;
            }

            self::response(true, "Students attendance summary fetched successfully", $students);

        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }

    // Update student information
    public static function updateStudent($conn, $stu_id, $full_name, $gender, $tel) {
        if (empty($stu_id)) self::response(false, "Student ID is required");
        if (empty($full_name) || empty($gender)) self::response(false, "Full name and gender are required");

        try {
            $stmt = $conn->prepare("UPDATE students SET full_name = ?, gender = ?, tel = ? WHERE id = ?");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
            $stmt->bind_param("sssi", $full_name, $gender, $tel, $stu_id);
            if (!$stmt->execute()) throw new Exception("Update failed: " . $stmt->error);

            self::response(true, "Student updated successfully");
        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }

    // Delete student and update total_stu in classes
    public static function deleteStudent($conn, $stu_id, $class_id) {
        if (empty($stu_id) || empty($class_id)) {
            self::response(false, "Student ID and Class ID are required");
        }

        $conn->begin_transaction();

        try {
            // Delete student
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
            $stmt->bind_param("i", $stu_id);
            if (!$stmt->execute()) throw new Exception("Failed to delete student: " . $stmt->error);

            // Update total_stu (subtract 1)
            $update = $conn->prepare("
                UPDATE classes
                SET total_stu = total_stu - 1
                WHERE id = ? AND total_stu > 0
            ");
            if (!$update) throw new Exception("Prepare update failed: " . $conn->error);
            $update->bind_param("i", $class_id);
            if (!$update->execute()) throw new Exception("Failed to update total_stu: " . $update->error);

            $conn->commit();
            self::response(true, "Student deleted successfully");

        } catch (Exception $e) {
            $conn->rollback();
            self::response(false, $e->getMessage());
        }
    }


}
?>
