<?php
require_once __DIR__ . '/../model/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'event_date' => $_POST['event_date'],
        'location' => $_POST['location'],
        'id' => $_POST['id']
    ];

    $sql = "UPDATE events SET title = ?, description = ?, event_date = ?, location = ? WHERE id = ?";
    
    if (db_query($sql, array_values($data), "ssssi")) {
        header("Location: ../view/index.php?success=2");
    } else {
        header("Location: ../view/index.php?error=2");
    }
    exit();
}

header("Location: ../view/index.php");
exit();