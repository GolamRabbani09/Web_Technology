<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registration Form</title>
    <link rel="stylesheet" href="../public/style1.css">
    <link rel="stylesheet" href="../public/style2.css">
    <style>
        .error { color: #d9534f; font-size: 0.9em; margin-left: 10px; }
        fieldset { margin-bottom: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        legend { padding: 0 10px; font-weight: bold; }
        label { display: inline-block; width: 150px; margin: 8px 0; }
        button { margin: 10px 5px; padding: 10px 20px; background-color: #5cb85c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button[type="reset"] { background-color: #f0ad4e; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Customer Registration</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?= $_SESSION['message_type'] === 'success' ? 'success' : 'error-message' ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <form action="../controllers/RegistrationController.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Personal Information</legend>
                
                <div class="form-group">
                    <label>First Name:*</label>
                    <input type="text" name="firstname" value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" required>
                    <?php if (isset($errors['firstname'])): ?>
                        <span class="error"><?= $errors['firstname'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Surname:*</label>
                    <input type="text" name="surname" value="<?= htmlspecialchars($formData['surname'] ?? '') ?>" required>
                    <?php if (isset($errors['surname'])): ?>
                        <span class="error"><?= $errors['surname'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Phone Number:*</label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($formData['phone'] ?? '') ?>" required>
                    <?php if (isset($errors['phone'])): ?>
                        <span class="error"><?= $errors['phone'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Date of Birth:*</label>
                    <input type="date" name="dob" value="<?= htmlspecialchars($formData['dob'] ?? '') ?>" required max="<?= date('Y-m-d') ?>">
                    <?php if (isset($errors['dob'])): ?>
                        <span class="error"><?= $errors['dob'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Address:*</label>
                    <input type="text" name="address" value="<?= htmlspecialchars($formData['address'] ?? '') ?>" required>
                    <?php if (isset($errors['address'])): ?>
                        <span class="error"><?= $errors['address'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Email:*</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <span class="error"><?= $errors['email'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Password:*</label>
                    <input type="password" name="password" required minlength="6">
                    <?php if (isset($errors['password'])): ?>
                        <span class="error"><?= $errors['password'] ?></span>
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Event Management</legend>
                <label>Select an Event Type:*</label><br>
                
                <?php 
                $eventTypes = [
                    'marriage' => 'Marriage Event',
                    'birthday' => 'Birthday Party',
                    'music' => 'Music Concerts & Live Shows',
                    'anniversary' => 'Anniversary Event',
                    'reunion' => 'Reunion Party'
                ];
                
                $selectedEvent = $formData['event'] ?? '';
                
                foreach ($eventTypes as $id => $label): ?>
                    <div class="radio-group">
                        <input type="radio" id="<?= $id ?>" name="event" 
                               value="<?= htmlspecialchars($label) ?>" 
                               <?= ($selectedEvent === $label) ? 'checked' : '' ?> required>
                        <label for="<?= $id ?>" style="width: auto; font-weight: normal;">
                            <?= htmlspecialchars($label) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                
                <?php if (isset($errors['event'])): ?>
                    <span class="error"><?= $errors['event'] ?></span>
                <?php endif; ?>
            </fieldset>
            
            <fieldset>
                <legend>Message to Admin</legend>
                <label>Your Message:</label><br>
                <textarea name="message" rows="4" cols="50"><?= htmlspecialchars($formData['message'] ?? '') ?></textarea>
            </fieldset>
            
            <div class="form-group">
                <label>Upload File (Max 2MB):*</label>
                <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required>
                <?php if (isset($errors['file'])): ?>
                    <span class="error"><?= $errors['file'] ?></span>
                <?php endif; ?>
            </div>
           
            <div class="form-actions">
                <button type="submit">Submit Registration</button>
                <button type="reset">Clear Form</button>
            </div>
        </form>
    </div>
    
    <script src="../public/myjs.js"></script>
</body>
</html>