<?php
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

require_once '../models/UserModel.php';

if (!isset($_GET['id'])) {
    header("Location: admin_home.php");
    exit();
}

$id = (int)$_GET['id'];
$user = get_user_by_id($id);

if (!$user) {
    header("Location: admin_home.php");
    exit();
}

$eventTypes = [
    'marriage' => 'Marriage Event',
    'birthday' => 'Birthday Party',
    'music' => 'Music Concerts & Live Shows',
    'anniversary' => 'Anniversary Event',
    'reunion' => 'Reunion Party'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../public/style1.css">
    <link rel="stylesheet" href="../public/style2.css">
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 150px; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        .back-btn { background-color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        
        <form action="../controllers/AdminController.php" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="hidden" name="update" value="1">
            
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Surname:</label>
                <input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Event Type:</label><br>
                <?php foreach ($eventTypes as $id => $label): ?>
                    <input type="radio" id="event_<?= $id ?>" name="event" 
                           value="<?= htmlspecialchars($label) ?>" 
                           <?= ($user['event_type'] === $label) ? 'checked' : '' ?> required>
                    <label for="event_<?= $id ?>" style="width: auto;"><?= htmlspecialchars($label) ?></label><br>
                <?php endforeach; ?>
            </div>
            
            <div class="form-group">
                <label>Message:</label>
                <textarea name="message" rows="4"><?= htmlspecialchars($user['message']) ?></textarea>
            </div>
            
            <button type="submit">Update User</button>
            <a href="admin_home.php" class="back-btn">Back to Admin</a>
        </form>
    </div>
</body>
</html>