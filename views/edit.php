<?php
include "../controller/edit_control.php";
$result = handleEdit();
$error = $result['error'];
$success = $result['success'];
$user = $result['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .btn-primary { background: #007bff; color: #fff; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .success { color: #28a745; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                
                <div class="form-group">
                    <label>Current Image</label>
                    <div class="current-image">
                        <?php if (!empty($user['myfile']) && file_exists("../uploads/" . $user['myfile'])): ?>
                            <img src="<?php echo "../uploads/" . htmlspecialchars($user['myfile']); ?>" 
                                alt="Current Profile Image" class="profile-preview">
                        <?php else: ?>
                            <span class="no-image">No image available</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_image">Change Image</label>
                    <input type="file" id="new_image" name="new_image" accept="image/*" class="file-input" onchange="previewImage(this)">
                    <div id="image-preview" class="preview-container"></div>
                </div>

                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" 
                           value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" id="surname" name="surname" 
                           value="<?php echo htmlspecialchars($user['surname']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" 
                           value="<?php echo htmlspecialchars($user['dob']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" 
                           value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="event">Event</label>
                    <input type="text" id="event" name="event" 
                           value="<?php echo htmlspecialchars($user['event']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="Admin_Home.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'profile-preview';
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
    


</script>

<style>
/* ...existing styles... */

.current-image {
    text-align: center;
    margin-bottom: 15px;
}

.profile-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #007bff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.preview-container {
    text-align: center;
    margin-top: 10px;
}

.no-image {
    display: inline-block;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
    color: #6c757d;
}

.file-input {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
    background: #f8f9fa;
}

.file-input:hover {
    background: #e9ecef;
}
</style>


</body>
</html>