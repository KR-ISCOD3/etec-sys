<?php
    class InstructorController {

        // JSON response helper
        private static function response($status, $message = "", $data = []) {
            echo json_encode([
                "status" => $status,
                "message" => $message,
                "data" => $data
            ]);
            exit;
        }

        // GET ALL instructors
        public static function getAll($conn) {
            $sql = "SELECT id, name, gender, tel, email, pass, role, approval, image, created_at, updated_at 
                    FROM users WHERE role = 'instructor'";
            $result = $conn->query($sql);

            if (!$result) {
                self::response(false, "Database error: ".$conn->error);
            }

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            self::response(true, "Instructors fetched successfully", $data);
        }

        // GET ONE instructor
        public static function get($conn, $id) {
            $stmt = $conn->prepare("SELECT id, name, gender, tel, email, role, approval, image, created_at, updated_at 
                                    FROM users WHERE id = ? AND role = 'instructor'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 0) self::response(false, "Instructor not found");
            $data = $res->fetch_assoc();
            self::response(true, "Instructor found", $data);
        }

        // CREATE instructor
        public static function create($conn, $name, $gender, $tel, $email, $pass, $image, $created_by) {
            $role = "instructor";
            $approval = "pending"; // default approval status

            $stmt = $conn->prepare("INSERT INTO users (name, gender, tel, email, pass, role, approval, image, created_at, updated_at) 
                                    VALUES (?,?,?,?,?,?,?,?,NOW(),NOW())");
            $stmt->bind_param("ssssssss", $name, $gender, $tel, $email, $pass, $role, $approval, $image);

            if ($stmt->execute()) {
                self::response(true, "Instructor created successfully");
            } else {
                self::response(false, "Create failed: ".$conn->error);
            }
        }

        // UPDATE instructor
        public static function update($conn, $id, $name, $gender, $tel, $email, $approval, $image) {
            $stmt = $conn->prepare("UPDATE users 
                                    SET name=?, gender=?, tel=?, email=?, approval=?, image=?, updated_at=NOW() 
                                    WHERE id=? AND role='instructor'");
            $stmt->bind_param("ssssssi", $name, $gender, $tel, $email, $approval, $image, $id);

            if ($stmt->execute()) {
                self::response(true, "Instructor updated successfully");
            } else {
                self::response(false, "Update failed: ".$conn->error);
            }
        }

        // DELETE instructor
        public static function delete($conn, $id) {
            // Delete classes belonging to this instructor
            $conn->query("DELETE FROM classes WHERE instructor_id = $id");

            // Then delete instructor
            $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='instructor'");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                self::response(true, "Instructor and related classes deleted successfully");
            } else {
                self::response(false, "Delete failed or instructor not found");
            }

            $stmt->close();
        }


    }
?>
