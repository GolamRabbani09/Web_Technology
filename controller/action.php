<?php

include "../models/db.php";

$fnameError = $surnameError = $phoneError = $dobError = $addressError = $emailError = $passwordError = $eventError = $myfileError = "";
$hasError = 0;
$myfile = "";

if (isset($_REQUEST["submit"])) {

    // Basic validation
    if (empty(trim($_REQUEST["firstname"]))) {
        $fnameError = "Invalid first name";
        $hasError = 1;
    }

    if (empty(trim($_REQUEST["surname"]))) {
        $surnameError = "Invalid surname";
        $hasError = 1;
    }

    if (empty(trim($_REQUEST["phone"])) || !preg_match("/^[0-9]{10,15}$/", $_REQUEST["phone"])) {
        $phoneError = "Invalid phone number";
        $hasError = 1;
    }

    if (empty($_REQUEST["dob"])) {
        $dobError = "Invalid date of birth";
        $hasError = 1;
    }

    if (empty(trim($_REQUEST["address"]))) {
        $addressError = "Invalid address";
        $hasError = 1;
    }

    if (empty($_REQUEST["email"]) || !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email";
        $hasError = 1;
    }

    if (empty($_REQUEST["password"]) || strlen($_REQUEST["password"]) < 6) {
        $passwordError = "Password must be at least 6 characters";
        $hasError = 1;
    }

    if (empty($_REQUEST["event"])) {
        $eventError = "Please select an event";
        $hasError = 1;
    }

    $message = !empty($_REQUEST["message"]) ? htmlspecialchars($_REQUEST["message"]) : "";

    if (!isset($_FILES["file"]) || $_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
        $myfileError = "Invalid file upload";
        $hasError = 1;
    } else {
        // Sanitize and rename file to avoid name collisions and security issues
        $originalName = basename($_FILES["file"]["name"]);
        $myfile = uniqid("upload_", true) . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $originalName);
    }

    if ($hasError == 0) {
        $conn = createConObject();

        if (insertData(
            $conn,
            $_REQUEST["firstname"],
            $_REQUEST["surname"],
            $_REQUEST["phone"],
            $_REQUEST["dob"],
            $_REQUEST["address"],
            $_REQUEST["email"],
            $_REQUEST["password"],  // Consider hashing the password!
            $_REQUEST["event"],
            $myfile
        )) {
            $uploadDir = __DIR__ . "/../uploads/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir,0777, true);
            }

            $targetFile = $uploadDir . $myfile;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                
                header("Location: ../views/login.php");
                exit();
            } else {
                $myfileError = "Failed to save uploaded file.";
            }
        } else {
            $messages = mysqli_error($conn);
        }

        closeCon($conn);
    }
}
?>




