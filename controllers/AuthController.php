<?php
class AuthController {

    // Helper to send JSON response
    private static function response($status, $message = "", $data = []) {
        echo json_encode([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
        exit;
    }

    // Register
    public static function register($conn) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') self::response(false, "Method not allowed");

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = 'instructor';

        try {
            $stmt = $conn->prepare("INSERT INTO users (name, email, gender, pass, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $gender, $password, $role);
            $stmt->execute();

            $user_id = $stmt->insert_id;

            $_SESSION['user'] = [
                "id" => $user_id,
                "name" => $name,
                "email" => $email,
                "role" => $role
            ];

            self::response(true, "Registration successful!", $_SESSION['user']);

        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) self::response(false, "Email already exists!");
            self::response(false, "Registration failed!");
        }
    }

    // Login
    public static function login($conn) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') self::response(false, "Method not allowed");

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $stmt = $conn->prepare("SELECT id, name, email, pass, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) self::response(false, "Email not found");

        if ($password === $user['pass']) {
            $_SESSION['user'] = [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ];
            self::response(true, "Login successful", $_SESSION['user']);
        } else {
            self::response(false, "Incorrect password");
        }
    }

    // Get profile
    public static function profile($conn) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') self::response(false, "Method not allowed");
        if (!isset($_SESSION['user'])) self::response(false, "Not logged in");

        $user_id = $_SESSION['user']['id'];
        $stmt = $conn->prepare("SELECT id, name, email, gender, tel, role, image, created_at, updated_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $profile = $result->fetch_assoc();

        if ($profile) self::response(true, "Profile fetched", $profile);
        self::response(false, "Profile not found");
    }

    // Logout
    public static function logout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') self::response(false, "Method not allowed");

        session_unset();
        session_destroy();
        self::response(true, "Logged out successfully");
    }
}
