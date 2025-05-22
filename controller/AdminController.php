<?php
require_once '../models/UserModel.php';

session_start();

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../views/login.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if (delete_user($id)) {
        $_SESSION['message'] = "User deleted successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete user";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../views/admin_home.php");
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $userData = [
        'firstname' => trim($_POST['firstname']),
        'surname' => trim($_POST['surname']),
        'phone' => trim($_POST['phone']),
        'dob' => $_POST['dob'],
        'address' => trim($_POST['address']),
        'email' => trim($_POST['email']),
        'event' => $_POST['event'],
        'message' => trim($_POST['message'] ?? '')
    ];

    if (update_user($id, $userData)) {
        $_SESSION['message'] = "User updated successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update user";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../views/admin_home.php");
    exit();
}

header("Location: ../views/admin_home.php");
exit();