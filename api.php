<?php
require_once(__DIR__ . '/config/db.php');
require_once(__DIR__ . '/controllers/AuthController.php');

require_once(__DIR__ . '/controllers/backend/CategoryController.php');

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

    default:
        response(false, "Invalid endpoint");
}
