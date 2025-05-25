
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../views/login.php");
    exit();
}

include "../models/db.php";

function handleEdit() {
    $error = '';
    $success = '';
    $user = null;

    try {
        $conn = createConObject();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle image upload
        $newImage = null;
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__) . "/uploads/";
            $originalName = basename($_FILES['new_image']['name']);
            $newImage = uniqid("upload_", true) . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $originalName);
            $targetFile = $uploadDir . $newImage;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetFile)) {
                // Delete old image if exists
                if (!empty($user['myfile'])) {
                    $oldFile = $uploadDir . $user['myfile'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $imageName = $newImage;
            } else {
                throw new Exception("Failed to upload new image");
            }
        }}
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!isset($_GET['id'])) {
                throw new Exception("User ID not provided");
            }
            
            $id = $_GET['id'];
            $result = getUserById($conn, $id);
            $user = mysqli_fetch_assoc($result);
            
            if (!$user) {
                throw new Exception("User not found");
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $surname = $_POST['surname'];
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $event = $_POST['event'];
            
            if (updateUser($conn, $id, $firstname, $surname, $phone, $dob, $address, $email, $event,$imageName)) {
                $success = "User updated successfully";
                header("refresh:2;url=../views/Admin_Home.php");
            } else {
                throw new Exception("Failed to update user");
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    } finally {
        if (isset($conn)) {
            closeCon($conn);
        }
    }

    return [
        'error' => $error,
        'success' => $success,
        'user' => $user
    ];
}