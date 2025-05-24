
<?php
session_start();
include ("../models/db.php");

if (isset($_POST["submit"])) {
    try {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $password = $_POST["password"];
        
        if(empty($email) || empty($password)) {
            throw new Exception("Email and password are required");
        }
        
        $conn = createConObject();
        $result = checkLogin($conn, $email, $password);
        
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "Login successful!";
            header("Location: ../views/Admin_Home.php");
            exit();
        } else {
            throw new Exception("Invalid email or password");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../views/login.php");
        exit();
    } finally {
        if (isset($conn)) {
            mysqli_close($conn);
        }
    }
}
?>

