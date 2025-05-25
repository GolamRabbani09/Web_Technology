
<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "../models/db.php";

try {
    $conn = createConObject();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Handle search
    $searchName = isset($_GET['search']) ? trim($_GET['search']) : '';
    $users = [];

    if (!empty($searchName)) {
        $users = searchUsersByName($conn, $searchName);
        if ($users === false) {
            throw new Exception("Search query failed");
        }
    } else {
        $result = getAllUsers($conn);
        if ($result === false) {
            throw new Exception("Failed to fetch users");
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Admin Home Error: " . $e->getMessage());
    $error_message = "An error occurred. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background: #f4f4f4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .search-box {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .search-box input[type="text"] {
            padding: 8px;
            width: 300px;
            margin-right: 10px;
        }
        .search-box button {
            padding: 8px 15px;
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .admin-actions a {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 5px;
        }
        .edit-btn { background: #28a745; }
        .delete-btn { background: #dc3545; }
        .logout-btn {
            padding: 8px 15px;
            background: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
            <a href="../controller/logout_control.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by name..." 
                   value="<?php echo htmlspecialchars($searchName); ?>">
            <button type="submit">Search</button>
            <button type="button" onclick="window.location='Admin_Home.php'">Reset</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Event</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td>
                        <?php
                            if (!empty($user['myfile'])) {
                                $imagePath = "../uploads/" . htmlspecialchars($user['myfile']);
                                error_log("Checking image path: " . $imagePath);
                                if (file_exists($imagePath)) {
                                    echo '<img class="profile-img" src="' . htmlspecialchars($imagePath) . '" alt="Profile Image">';
                                } else {
                                    error_log("Image not found at: " . $imagePath);
                                    echo '<span style="color:gray;">Image not found: ' . htmlspecialchars($imagePath) . '</span>';
                                }
                            } else {
                                echo '<span style="color:gray;">No Image</span>';
                            }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($user['surname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['event']); ?></td>
                    <td class="admin-actions">
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="edit-btn">Edit</a>
                        <a href="../controller/delete.php?id=<?php echo $user['id']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this user?')" 
                                class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center;">No users found</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php 
mysqli_close($conn);
?>