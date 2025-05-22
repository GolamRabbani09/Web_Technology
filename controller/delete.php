<?php
require_once __DIR__ . '/../model/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $sql = "DELETE FROM events WHERE id = ?";
    
    if (db_delete($sql, [$_POST['id']], "i")) {
        header("Location: ../view/index.php?success=3");
    } else {
        header("Location: ../view/index.php?error=3");
    }
    exit();
}

header("Location: ../view/index.php");
exit();