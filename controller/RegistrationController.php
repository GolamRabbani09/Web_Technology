<?php
require_once '../models/UserModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $userData = [
        'firstname' => trim($_POST['firstname']),
        'surname' => trim($_POST['surname']),
        'phone' => trim($_POST['phone']),
        'dob' => $_POST['dob'],
        'address' => trim($_POST['address']),
        'email' => trim($_POST['email']),
        'password' => $_POST['password'],
        'event' => $_POST['event'],
        'message' => trim($_POST['message'] ?? ''),
        'file_path' => null
    ];

    // File upload handling
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['file']['tmp_name']);
        finfo_close($fileInfo);
        
        if (in_array($mimeType, $allowedTypes) && $_FILES['file']['size'] <= $maxSize) {
            $uploadDir = '../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExt = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('event_', true) . '.' . $fileExt;
            $targetFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                $userData['file_path'] = $fileName;
            } else {
                $errors['file'] = "Failed to upload file";
            }
        } else {
            $errors['file'] = "Invalid file type or size (max 2MB)";
        }
    } else {
        $errors['file'] = "Please upload a file";
    }

    // Validation
    if (empty($userData['firstname'])) $errors['firstname'] = "First name is required";
    if (empty($userData['surname'])) $errors['surname'] = "Surname is required";
    if (empty($userData['phone'])) $errors['phone'] = "Phone number is required";
    if (empty($userData['dob'])) $errors['dob'] = "Date of birth is required";
    if (empty($userData['address'])) $errors['address'] = "Address is required";
    if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required";
    }
    if (strlen($userData['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }
    if (empty($userData['event'])) {
        $errors['event'] = "Event type is required";
    }

    if (empty($errors)) {
        if ($userId = register_user($userData)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['message'] = "Registration successful!";
            $_SESSION['message_type'] = "success";
            header("Location: ../views/home.php");
            exit();
        } else {
            $errors['database'] = "Registration failed. Please try again.";
        }
    }
    
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $userData;
    header("Location: ../views/registration_form.php");
    exit();
}

header("Location: ../views/registration_form.php");
exit();