<?php
$success = isset($_GET['success']);
$error = isset($_GET['error']);
$events = $events ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Management</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Event Management System</h1>
        
        <?php if ($success): ?>
            <div class="alert success">Operation completed successfully!</div>
        <?php elseif ($error): ?>
            <div class="alert error">Operation failed. Please try again.</div>
        <?php endif; ?>
        
        <div class="actions">
            <a href="registration_form.php" class="btn">Create New Event</a>
        </div>
        
        <div class="events-list">
            <?php foreach ($events as $event): ?>
            <div class="event-card">
                <?php if ($event['image_path']): ?>
                <img src="../uploads/<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                <?php endif; ?>
                
                <h3><?= htmlspecialchars($event['title']) ?></h3>
                <p><?= htmlspecialchars($event['description']) ?></p>
                <p><strong>Date:</strong> <?= date('M j, Y H:i', strtotime($event['event_date'])) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                
                <div class="event-actions">
                    <form method="POST" action="../controller/delete.php" class="inline-form">
                        <input type="hidden" name="id" value="<?= $event['id'] ?>">
                        <button type="submit" class="btn danger">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>