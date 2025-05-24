
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../views/login.php");
    exit();
}

include "../models/db.php";

try {
    if (!isset($_GET['id'])) {
        throw new Exception("User ID not provided");
    }

    $conn = createConObject();
    $id = $_GET['id'];
    
    if (deleteUser($conn, $id)) {
        header("Location: ../views/Admin_Home.php?message=User+deleted+successfully");
        exit();
    } else {
        throw new Exception("Failed to delete user");
    }
} catch (Exception $e) {
    error_log("Delete Error: " . $e->getMessage());
    header("Location: ../views/Admin_Home.php?error=" . urlencode($e->getMessage()));
    exit();
} finally {
    if (isset($conn)) {
        closeCon($conn);
    }
}