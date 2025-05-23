<?php
// Database connection
include "../models/db.php";
$conn = createConObject();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$id = $name = $email = "";
$edit_mode = false;
$message = "";

// Handle form submission for Add or Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Update existing user
        $id = (int)$_POST["id"];
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        if ($stmt->execute()) {
            $message = "Record updated successfully.";
        } else {
            $message = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    } else {
        // Add new user
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()) {
            $message = "New record added successfully.";
        } else {
            $message = "Error adding record: " . $conn->error;
        }
        $stmt->close();
    }
}

// Handle delete request
if (isset($_GET["delete"])) {
    $del_id = (int)$_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    if ($stmt->execute()) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// Handle edit request - load data into form
if (isset($_GET["edit"])) {
    $edit_id = (int)$_GET["edit"];
    $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $name = $row["name"];
        $email = $row["email"];
        $edit_mode = true;
    }
    $stmt->close();
}

// Fetch all users for display
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard - CRUD Management</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 20px auto;
        max-width: 900px;
        background: #f9f9f9;
        color: #333;
    }
    h2 {
        text-align: center;
        color: #2c3e50;
    }
    form {
        background: white;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    }
    label {
        display: block;
        margin-top: 15px;
        font-weight: 600;
        color: #34495e;
    }
    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
        box-sizing: border-box;
    }
    input[type="submit"], input[type="reset"], .cancel-btn {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        color: white;
    }
    input[type="submit"] {
        background-color: #2980b9;
    }
    input[type="submit"]:hover {
        background-color: #1f6391;
    }
    input[type="reset"], .cancel-btn {
        background-color: #7f8c8d;
        margin-left: 10px;
    }
    input[type="reset"]:hover, .cancel-btn:hover {
        background-color: #636e70;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    }
    th, td {
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #34495e;
        color: #ecf0f1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    a.action-btn {
        display: inline-block;
        margin-right: 10px;
        padding: 6px 12px;
        color: #2980b9;
        text-decoration: none;
        border: 1px solid #2980b9;
        border-radius: 4px;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    a.action-btn:hover {
        background-color: #2980b9;
        color: white;
    }
    .message {
        margin-bottom: 20px;
        padding: 12px 20px;
        background-color: #dff0d8;
        color: #3c763d;
        border-radius: 6px;
        border: 1px solid #d0e9c6;
        font-size: 1rem;
    }
    .cancel-btn {
        padding: 10px 20px;
        display: inline-block;
        background: #7f8c8d;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        font-weight: 600;
    }
</style>
</head>
<body>

<h2>Admin Dashboard - Users Management</h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>" />

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" />

    <input type="submit" value="<?php echo $edit_mode ? 'Update User' : 'Add User'; ?>" />
    <?php if ($edit_mode): ?>
        <a href="admin_dashboard.php" class="cancel-btn">Cancel</a>
    <?php else: ?>
        <input type="reset" value="Clear" />
    <?php endif; ?>
</form>

<table>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["id"]); ?></td>
                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                <td>
                    <a class="action-btn" href="?edit=<?php echo $row["id"]; ?>">Edit</a>
                    <a class="action-btn" href="?delete=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4" style="text-align:center;">No records found</td></tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>

