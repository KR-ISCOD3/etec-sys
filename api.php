<?php
require_once(__DIR__ . '/config/db.php');
require_once(__DIR__ . '/controllers/AuthController.php');

require_once(__DIR__ . '/controllers/backend/CategoryController.php');
require_once(__DIR__ . '/controllers/backend/CourseController.php');

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

    default:
        response(false, "Invalid endpoint");
}
