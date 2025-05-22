<?php
session_start();

// Define base path
define('BASE_PATH', __DIR__ . '/');

// Route the request
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/public', '', $request);
$request = trim($request, '/');

switch ($request) {
    case '':
    case 'home':
        require '../views/home.php';
        break;
    case 'login':
        require '../views/login.php';
        break;
    case 'process-login':
        require '../controllers/LoginController.php';
        break;
    case 'logout':
        session_destroy();
        header("Location: login");
        exit();
        break;
    case 'register':
        require '../views/registration_form.php';
        break;
    case 'process-registration':
        require '../controllers/RegistrationController.php';
        break;
    case 'admin':
        require '../views/admin_home.php';
        break;
    case 'edit-user':
        require '../views/edit_user.php';
        break;
    case 'process-admin':
        require '../controllers/AdminController.php';
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}