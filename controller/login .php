<?php
require_once __DIR__ . '/../model/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $user = db_get_one($sql, [$email], "s");
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: ../view/index.php");
    } else {
        header("Location: ../view/login.php?error=1");
    }
    exit();
}

header("Location: ../view/login.php");
exit();