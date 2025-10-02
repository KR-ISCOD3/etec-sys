<?php

class ClassController {

    private static function response($status, $message = "", $data = []) {
        echo json_encode([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
        exit;
    }

    // CREATE a class with total_stu default to 0
    public static function create($conn, $lesson, $class_status, $course_id, $instructor_id = null, $building_id, $floor_id, $room_id, $class_type_id, $time_id, $term_id){
        
        $total_stu = 0; // default student count

        $stmt = $conn->prepare("
            INSERT INTO classes 
            (lesson, total_stu, class_status, course_id, instructor_id, building_id, floor_id, room_id, class_type_id, time_id, term_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            self::response(false, "Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "sisiiiiiiii", 
            $lesson,       // s = string
            $total_stu,    // i = int
            $class_status, // s = string
            $course_id,    // i
            $instructor_id,// i
            $building_id,  // i
            $floor_id,     // i
            $room_id,      // i
            $class_type_id,// i
            $time_id,      // i
            $term_id       // i
        );


        if ($stmt->execute()) {
            self::response(true, "Class created successfully", ["id" => $stmt->insert_id]);
        } else {
            self::response(false, "Create failed: " . $conn->error);
        }
    }


    // GET classes for a specific instructor
    public static function getByInstructor($conn, $instructor_id) {
        if (!$instructor_id) {
            self::response(false, "Instructor ID is required");
        }

        $sql = "
            SELECT 
                c.id,
                c.lesson,
                c.total_stu,
                c.class_status,
                cr.course AS course_name,
                u.name AS instructor_name,
                b.name AS building_name,
                f.floor AS floor_name,
                r.room AS room_name,
                ct.name AS class_type,
                t.time,
                te.term AS term_name,
                c.course_id,
                c.instructor_id,
                c.floor_id,
                c.room_id,
                c.class_type_id,
                c.time_id,
                c.term_id,
                c.building_id
            FROM classes c
            LEFT JOIN courses cr ON c.course_id = cr.id
            LEFT JOIN users u ON c.instructor_id = u.id
            LEFT JOIN buildings b ON c.building_id = b.id
            LEFT JOIN floors f ON c.floor_id = f.id
            LEFT JOIN rooms r ON c.room_id = r.id
            LEFT JOIN class_types ct ON c.class_type_id = ct.id
            LEFT JOIN times t ON c.time_id = t.id
            LEFT JOIN terms te ON c.term_id = te.id
            WHERE c.instructor_id = ?
            ORDER BY c.id DESC
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            self::response(false, "Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $instructor_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $classes = [];
        while ($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }

        self::response(true, "Classes retrieved successfully", $classes);
    }

    // UPDATE a class
    public static function update($conn, $id, $lesson, $class_status, $course_id, $instructor_id = null, $building_id, $floor_id, $room_id, $class_type_id, $time_id, $term_id) {

        // Validation
        if (!$id) {
            self::response(false, "Class ID is required");
        }

        $stmt = $conn->prepare("
            UPDATE classes SET
                lesson = ?,
                class_status = ?,
                course_id = ?,
                instructor_id = ?,
                building_id = ?,
                floor_id = ?,
                room_id = ?,
                class_type_id = ?,
                time_id = ?,
                term_id = ?
            WHERE id = ?
        ");

        if (!$stmt) {
            self::response(false, "Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "ssiiiiiiiii", 
            $lesson,       // s = string
            $class_status, // s = string
            $course_id,    // i
            $instructor_id,// i (nullable)
            $building_id,  // i
            $floor_id,     // i
            $room_id,      // i
            $class_type_id,// i
            $time_id,      // i
            $term_id,      // i
            $id            // i = class ID
        );

        if ($stmt->execute()) {
            self::response(true, "Class updated successfully");
        } else {
            self::response(false, "Update failed: " . $conn->error);
        }
    }

    
    // TRANSFER CLASS
    public static function transferClass($conn, $class_id, $instructor_id) {
        try {
            // 1️⃣ Find the class by ID
            $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
            if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $class = $result->fetch_assoc();

            if (!$class) {
                self::response(false, "Class not found. Please select a valid class.");
            }

            // 2️⃣ Check if the instructor exists
            $checkInstructor = $conn->prepare("SELECT id, name FROM users WHERE id = ?");
            if (!$checkInstructor) throw new Exception("Prepare failed: " . $conn->error);
            $checkInstructor->bind_param("i", $instructor_id);
            $checkInstructor->execute();
            $insResult = $checkInstructor->get_result();
            $instructor = $insResult->fetch_assoc();

            if (!$instructor) {
                self::response(false, "Instructor ID {$instructor_id} not found. Please enter a valid instructor.");
            }

            // 3️⃣ Optional: Prevent transferring to same instructor
            if ($class['instructor_id'] == $instructor_id) {
                self::response(false, "This class is already assigned to {$instructor['name']}.");
            }

            // 4️⃣ Insert a new class row with the same data but new instructor_id
            $insert = $conn->prepare("
                INSERT INTO classes 
                (lesson, total_stu, class_status, course_id, instructor_id, building_id, floor_id, room_id, class_type_id, time_id, term_id, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            if (!$insert) throw new Exception("Prepare insert failed: " . $conn->error);

            $insert->bind_param(
                "sisiiiiiiii",
                $class['lesson'],         // lesson
                $class['total_stu'],      // total_stu
                $class['class_status'],   // class_status
                $class['course_id'],      // course_id
                $instructor_id,           // new instructor
                $class['building_id'],    // building_id
                $class['floor_id'],       // floor_id
                $class['room_id'],        // room_id
                $class['class_type_id'],  // class_type_id
                $class['time_id'],        // time_id
                $class['term_id']         // term_id
            );

            if ($insert->execute()) {
                self::response(true, "Class transferred successfully to {$instructor['name']}", ["new_class_id" => $insert->insert_id]);
            } else {
                self::response(false, "Transfer failed: " . $conn->error);
            }

        } catch (Exception $e) {
            self::response(false, $e->getMessage());
        }
    }

}
?>
