<?php
require_once(__DIR__ . '/config/db.php');
require_once(__DIR__ . '/controllers/AuthController.php');

require_once(__DIR__ . '/controllers/backend/CategoryController.php');
require_once(__DIR__ . '/controllers/backend/CourseController.php');
require_once(__DIR__ . '/controllers/backend/RoadmapController.php');
require_once(__DIR__ . '/controllers/backend/ClassTypesController.php');
require_once(__DIR__ . '/controllers/backend/TermAndTimeController.php');
require_once(__DIR__ . '/controllers/backend/ScheduleController.php');
require_once(__DIR__ . '/controllers/backend/BuildingController.php');
require_once(__DIR__ . '/controllers/backend/InstructorController.php');
require_once(__DIR__ . '/controllers/frontend/ClassController.php');


header('Content-Type: application/json');
session_start();

function response($status, $message = "", $data = []) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {

    // --- Auth ---
    case 'register':
        if ($method !== 'POST') response(false, "Method not allowed");
        AuthController::register($conn);
    break;

    case 'login':
        if ($method !== 'POST') response(false, "Method not allowed");
        AuthController::login($conn);
    break;

    case 'profile':
        if ($method !== 'GET') response(false, "Method not allowed");
        AuthController::profile($conn);
    break;

    // Get all pending users (for admin)
    case 'getPendingUsers':
        if ($method !== 'GET') response(false, "Method not allowed");
        AuthController::getPendingUsers($conn);
    break;

    // Approve or reject a user (for admin)
    case 'updateApproval':
        if ($method !== 'POST') response(false, "Method not allowed");
        AuthController::updateApproval($conn);
    break;

    case 'checkApproval':
        if ($method !== 'GET') response(false, "Method not allowed");
        AuthController::checkApproval($conn);
    break;


    case 'logout':
        if ($method !== 'POST') response(false, "Method not allowed");
        AuthController::logout();
    break;

    // --- Category CRUD ---
    case 'category_get_all':
        if ($method !== 'GET') response(false, "Method not allowed");
        CategoryController::getAll($conn);
    break;

    case 'category_get':
        if ($method !== 'GET') response(false, "Method not allowed");
        $id = intval($_GET['id'] ?? 0);
        CategoryController::get($conn, $id);
    break;

    case 'category_getsome':
        if ($method !== 'GET') response(false, "Method not allowed");
        CategoryController::getSomeCategory($conn);
    break;

    case 'category_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $category = $_POST['category'] ?? '';
        $created_by = $_SESSION['user']['id'] ?? null;
        CategoryController::create($conn, $category, $created_by);
    break;

    case 'category_update':
        if ($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        $category = $_POST['category'] ?? '';
        CategoryController::update($conn, $id, $category);
    break;

    case 'category_delete':
        if ($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        CategoryController::delete($conn, $id);
    break;


    // --- Courses ---
    case 'course_getall':
        if ($method !== 'GET') response(false, "Method not allowed");
        CourseController::getAll($conn);
    break;

    case 'course_get':
        if ($method !== 'GET') response(false, "Method not allowed");
        $id = $_GET['id'] ?? 0;
        CourseController::get($conn, $id);
    break;

    case 'course_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $course = $_POST['course'] ?? null;
        $category_id = $_POST['category_id'] ?? null;
        $created_by = $_SESSION['user']['id'] ?? null;
        
        CourseController::create($conn, $course, $category_id, $created_by);
    break;

    case 'course_update':
        if ($method !== 'POST') response(false, "Method not allowed");

        // Get data from POST
        $id = intval($_POST['id'] ?? 0);
        $course = $_POST['course'] ?? '';
        $category_id = intval($_POST['category_id'] ?? 0);

        // Call the update function
        CourseController::update($conn, $id, $course, $category_id);
    break;

    case 'course_delete':
        if($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        CourseController::delete($conn, $id);
    break;

    // --- Roadmaps ---
    case 'roadmap_getall':
        if ($method !== 'GET') response(false, "Method not allowed");
        RoadmapController::getAll($conn);
    break;

    case 'roadmap_get':
        if ($method !== 'GET') response(false, "Method not allowed");
        $id = $_GET['id'] ?? 0;
        RoadmapController::get($conn, $id);
    break;

    case 'roadmap_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $course_id = $_POST['course_id'] ?? null;
        $lesson = $_POST['lessons'] ?? null;
        $created_by = $_SESSION['user']['id'] ?? 1; // fallback to 1 if session missing
        RoadmapController::create($conn, $course_id, $lesson, $created_by);
    break;

    case 'roadmap_update':
        if ($method !== 'POST') response(false, "Method not allowed"); // changed from PUT
        $id = $_POST['id'] ?? null;
        $course_id = $_POST['course_id'] ?? null;
        $lesson = $_POST['lessons'] ?? null;
        RoadmapController::update($conn, $id, $course_id, $lesson);
    break;

    case 'roadmap_delete':
        if ($method !== 'POST') response(false, "Method not allowed"); // changed from DELETE
        $id = $_POST['id'] ?? 0;
        RoadmapController::delete($conn, $id);
    break;


    // --- CLASS TYPES CRUD ---
    case 'class_type_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $name = $_POST['name'] ?? null;
        $created_by = $_SESSION['user']['id'] ?? 1; // fallback to 1 if session missing
        ClassTypesController::create($conn, $name, $created_by);
    break;

    case 'class_type_update':
        if ($method !== 'POST') response(false, "Method not allowed"); // using POST for simplicity
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;
        ClassTypesController::update($conn, $id, $name);
    break;

    case 'class_type_delete':
        if ($method !== 'POST') response(false, "Method not allowed"); // using POST for simplicity
        $id = $_POST['id'] ?? 0;
        ClassTypesController::delete($conn, $id);
    break;

    case 'class_type_get_all':
        if ($method !== 'GET') response(false, "Method not allowed");
        ClassTypesController::getAll($conn);
    break;
    
     // --- TERMS CRUD ---
    case 'term_get_all':
        if($method !== 'GET') response(false, "Method not allowed");
        TermAndTimeController::getAllTerms($conn);
    break;

    case 'term_create':
        if($method !== 'POST') response(false, "Method not allowed");
        $term = $_POST['term'] ?? '';
        $created_by = $_SESSION['user']['id'] ?? 1;
        TermAndTimeController::createTerm($conn, $term, $created_by);
    break;

    case 'term_update':
        if($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        $term = $_POST['term'] ?? '';
        TermAndTimeController::updateTerm($conn, $id, $term);
    break;

    case 'term_delete':
        if($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        TermAndTimeController::deleteTerm($conn, $id);
    break;

    // --- TIMES CRUD ---
    case 'time_get_all':
        if($method !== 'GET') response(false, "Method not allowed");
        TermAndTimeController::getAllTimes($conn);
    break;

    case 'time_create':
        if($method !== 'POST') response(false, "Method not allowed");
        $time_slot = $_POST['time'] ?? '';
        $created_by = $_SESSION['user']['id'] ?? 1; // keep created_by
        TermAndTimeController::createTime($conn, $time_slot, $created_by);
    break;

    case 'time_update':
        if($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        $time_slot = $_POST['time'] ?? '';
        TermAndTimeController::updateTime($conn, $id, $time_slot);
    break;

    case 'time_delete':
        if($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        TermAndTimeController::deleteTime($conn, $id);
    break;


    // --- SCHEDULES CRUD ---
    case 'schedule_getall':
        if ($method !== 'GET') response(false, "Method not allowed");
        ScheduleController::getAll($conn);
    break;

    case 'schedule_get':
        if ($method !== 'GET') response(false, "Method not allowed");
        $id = intval($_GET['id'] ?? 0);
        ScheduleController::get($conn, $id);
    break;

    case 'schedule_create':
        if ($method !== 'POST') response(false, "Method not allowed");

        $class_type_id = intval($_POST['class_type_id'] ?? 0);
        $term_id = intval($_POST['term_id'] ?? 0);
        $time_ids = $_POST['time_ids'] ?? [];
        $created_by = $_SESSION['user']['id'] ?? 1;

        if (empty($time_ids)) {
            response(false, "No time slots selected");
        }

        // Build bulk insert
        $values = [];
        $params = [];
        $types = '';
        foreach ($time_ids as $time_id) {
            $time_id = intval($time_id);
            $values[] = "(?, ?, ?, ?)";
            $params[] = $class_type_id;
            $params[] = $term_id;
            $params[] = $time_id;
            $params[] = $created_by;
            $types .= "iiii";
        }

        $sql = "INSERT INTO schedules (class_type_id, term_id, time_id, created_by) VALUES " . implode(',', $values);
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            response(true, "Schedules created successfully");
        } else {
            response(false, "Create failed: " . $conn->error);
        }

    break;

    case 'schedule_delete':
        if ($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        ScheduleController::deleteByClassType($conn, $id);
    break;

    case 'schedule_term_delete':
        if ($method !== 'POST') response(false, "Method not allowed");

        $classTypeId = intval($_POST['class_type_id'] ?? 0);
        $termId = intval($_POST['term_id'] ?? 0);

        if ($classTypeId && $termId) {
            ScheduleController::deleteByClassTypeAndTerm($conn, $classTypeId, $termId);
        } else {
            response(false, "Both class_type_id and term_id are required for deletion.");
        }
    break;

    case 'building_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $buildingName = $_POST['building_name'] ?? '';
        $floors = $_POST['floors'] ?? '[]';
        $createdBy = $_SESSION['user']['id'] ?? 1;

        BuildingController::create($conn, $buildingName, $floors, $createdBy);
    break;

    case 'building_fetch_all':
        if ($method !== 'GET') response(false, "Method not allowed");
        BuildingController::fetchAll($conn);
    break;
    
    case 'building_update':
        if ($method !== 'POST') {
            response(false, "Method not allowed");
        }

        $buildingId = $_POST['building_id'] ?? 0;
        $buildingName = $_POST['building_name'] ?? '';
        $floors = $_POST['floors'] ?? '[]';
        $updatedBy = $_SESSION['user']['id'] ?? 1;

        BuildingController::update($conn, $buildingId, $buildingName, $floors, $updatedBy);
    break;

    case 'building_delete':
        if ($method !== 'POST') response(false, "Method not allowed");
        $buildingId = intval($_POST['building_id'] ?? 0);
        if ($buildingId > 0) {
            BuildingController::delete($conn, $buildingId);
        } else {
            response(false, "Invalid building ID");
        }
    break;
    
         // --- INSTRUCTOR CRUD ---
    case 'instructor_getall':
        if ($method !== 'GET') response(false, "Method not allowed");
        InstructorController::getAll($conn);
    break;

    case 'instructor_get':
        if ($method !== 'GET') response(false, "Method not allowed");
        $id = intval($_GET['id'] ?? 0);
        InstructorController::get($conn, $id);
    break;

    case 'instructor_create':
        if ($method !== 'POST') response(false, "Method not allowed");
        $name = $_POST['name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass = $_POST['pass'] ?? '';
        $image = $_POST['image'] ?? '';
        $created_by = $_SESSION['user']['id'] ?? 1;

        InstructorController::create($conn, $name, $gender, $tel, $email, $pass, $image, $created_by);
    break;

    case 'instructor_update':
        if ($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        $name = $_POST['name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $email = $_POST['email'] ?? '';
        $approval = $_POST['approval'] ?? 'pending';
        $image = $_POST['image'] ?? '';

        InstructorController::update($conn, $id, $name, $gender, $tel, $email, $approval, $image);
    break;

    case 'instructor_delete':
        if ($method !== 'POST') response(false, "Method not allowed");
        $id = intval($_POST['id'] ?? 0);
        InstructorController::delete($conn, $id);
    break;

    // --- CLASSES CRUD ---
    case 'class_create':
        if ($method !== 'POST') response(false, "Method not allowed");

        // Get POST data
        $lesson = $_POST['lesson'] ?? '';
        $class_status = $_POST['class_status'] ?? '';
        $course_id = intval($_POST['course_id'] ?? 0);
        $instructor_id = intval($_SESSION['user']['id'] ?? 1);
        $building_id = intval($_POST['building_id'] ?? 0);
        $floor_id = intval($_POST['floor_id'] ?? 0);
        $room_id = intval($_POST['room_id'] ?? 0);
        $status_id = intval($_POST['status_id'] ?? 0);
        $class_type_id = intval($_POST['class_type_id'] ?? 0);
        $time_id = intval($_POST['time_id'] ?? 0);
        $term_id = intval($_POST['term_id'] ?? 0);

        ClassController::create(
            $conn, 
            $lesson, 
            $class_status, 
            $course_id, 
            $instructor_id, 
            $building_id, 
            $floor_id, 
            $room_id, 
            $class_type_id, // correct
            $time_id, 
            $term_id
        );

    break;
    
    default:
        response(false, "Invalid endpoint");
}
