<?php
require_once __DIR__ . '/../model/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'event_date' => $_POST['event_date'],
        'location' => $_POST['location'],
        'image_path' => null
    ];

    // Handle file upload
    if (isset($_FILES['image'])) {
        $target_dir = __DIR__ . "/../uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_name = basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $file_name)) {
            $data['image_path'] = $file_name;
        }
    }

    $sql = "INSERT INTO events (title, description, event_date, location, image_path) 
            VALUES (?, ?, ?, ?, ?)";
    
    if (db_insert($sql, array_values($data), "sssss")) {
        header("Location: ../view/index.php?success=1");
    } else {
        header("Location: ../view/registration_form.php?error=1");
    }
    exit();
}