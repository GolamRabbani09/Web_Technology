<?php
include ("../models/db.php");

if (isset($_POST["submit"])) {
    // Get email and password from POST data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate inputs
    if(empty($email) || empty($password)) {
        echo "Email and password are required";
        exit();
    }
    
    $conn = createConObject();
    $result = checkLogin($conn, $email, $password);
    
    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ../views/Admin_Home.php");
        exit();
    } else {
        echo "Invalid email or password";
    }
    
    mysqli_close($conn);
}
?>