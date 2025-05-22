<?php
require_once '../models/UserModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if ($user = authenticate_user($email, $password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = ($user['email'] === 'admin@example.com'); // Simple admin check
        
        if ($_SESSION['is_admin']) {
            header("Location: ../views/admin_home.php");
        } else {
            header("Location: ../views/home.php");
        }
        exit();
    } else {
        $_SESSION['message'] = "Invalid email or password";
        $_SESSION['message_type'] = "error";
        header("Location: ../views/login.php");
        exit();
    }
}

header("Location: ../views/login.php");
exit();