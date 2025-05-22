<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../public/style1.css">
    <link rel="stylesheet" href="../public/style2.css">
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .welcome { font-size: 1.5em; margin-bottom: 20px; }
        .actions { margin-top: 20px; }
        .logout-btn { background-color: #d9534f; }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">Welcome, <?= htmlspecialchars($_SESSION['user_email']) ?></div>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?= $_SESSION['message_type'] === 'success' ? 'success' : 'error' ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <p>You have successfully logged in to the event management system.</p>
        
        <div class="actions">
            <a href="login.php?action=logout" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>