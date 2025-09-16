<?php
require_once(__DIR__ . '/config/db.php');
require_once(__DIR__ . '/controllers/AuthController.php');

require_once(__DIR__ . '/controllers/backend/CategoryController.php');
require_once(__DIR__ . '/controllers/backend/CourseController.php');
require_once(__DIR__ . '/controllers/backend/RoadmapController.php');
require_once(__DIR__ . '/controllers/backend/ClassTypesController.php');
require_once(__DIR__ . '/controllers/backend/TermAndTimeController.php');

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

    default:
        response(false, "Invalid endpoint");
}
