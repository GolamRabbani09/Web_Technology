<?php
require_once 'Database.php';

/**
 * Registers a new user
 * @param array $userData User data
 * @return int|false Returns user ID or false on failure
 */
function register_user($userData) {
    $sql = "INSERT INTO users (firstname, surname, phone, dob, address, email, password, event_type, message, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    return db_insert($sql, [
        $userData['firstname'],
        $userData['surname'],
        $userData['phone'],
        $userData['dob'],
        $userData['address'],
        $userData['email'],
        $hashedPassword,
        $userData['event'],
        $userData['message'],
        $userData['file_path']
    ], "ssssssssss");
}

/**
 * Authenticates a user
 * @param string $email User email
 * @param string $password User password
 * @return array|false Returns user data or false on failure
 */
function authenticate_user($email, $password) {
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $result = db_query($sql, [$email], "s");
    
    if ($result && $user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

/**
 * Gets all users
 * @return array Returns array of users
 */
function get_all_users() {
    $sql = "SELECT * FROM users";
    $result = db_query($sql);
    $users = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    
    return $users;
}

/**
 * Gets a user by ID
 * @param int $id User ID
 * @return array|false Returns user data or false if not found
 */
function get_user_by_id($id) {
    $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $result = db_query($sql, [$id], "i");
    
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

/**
 * Updates a user
 * @param int $id User ID
 * @param array $userData User data
 * @return bool Returns true on success, false on failure
 */
function update_user($id, $userData) {
    $sql = "UPDATE users SET 
            firstname = ?, 
            surname = ?, 
            phone = ?, 
            dob = ?, 
            address = ?, 
            email = ?, 
            event_type = ?, 
            message = ? 
            WHERE id = ?";
    
    return db_update($sql, [
        $userData['firstname'],
        $userData['surname'],
        $userData['phone'],
        $userData['dob'],
        $userData['address'],
        $userData['email'],
        $userData['event'],
        $userData['message'],
        $id
    ], "ssssssssi");
}

/**
 * Deletes a user
 * @param int $id User ID
 * @return bool Returns true on success, false on failure
 */
function delete_user($id) {
    $sql = "DELETE FROM users WHERE id = ?";
    return db_delete($sql, [$id], "i");
}