<?php
$success = isset($_GET['success']);
$error = isset($_GET['error']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Registration</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Create New Event</h1>
        
        <?php if ($success): ?>
            <div class="alert success">Event created successfully!</div>
        <?php elseif ($error): ?>
            <div class="alert error">Error creating event. Please try again.</div>
        <?php endif; ?>
        
        <form method="POST" action="../controller/create.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="datetime-local" name="event_date" required>
            </div>
            
            <div class="form-group">
                <label>Location:</label>
                <input type="text" name="location" required>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image">
            </div>
            
            <button type="submit">Create Event</button>
        </form>
    </div>
</body>
</html>