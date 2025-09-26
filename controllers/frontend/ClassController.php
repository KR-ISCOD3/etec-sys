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
    public static function create(
        $conn, 
        $lesson, 
        $class_status, 
        $course_id, 
        $instructor_id, 
        $building_id, 
        $floor_id, 
        $room_id, 
        $class_type_id, 
        $time_id, 
        $term_id
    ) {
        
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

}
?>
