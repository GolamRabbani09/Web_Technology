<?php
// Database configuration
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "event_management";

// Create connection
function db_connect() {
    global $db_host, $db_user, $db_pass, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Execute query with parameters
function db_query($sql, $params = [], $types = "") {
    $conn = db_connect();
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) die("Prepare failed: " . $conn->error);
    
    if (!empty($params)) $stmt->bind_param($types, ...$params);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stmt->close();
    $conn->close();
    return $result;
}

// Insert data and return ID
function db_insert($sql, $params = [], $types = "") {
    $conn = db_connect();
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) die("Prepare failed: " . $conn->error);
    
    $stmt->bind_param($types, ...$params);
    $success = $stmt->execute();
    $insert_id = $stmt->insert_id;
    
    $stmt->close();
    $conn->close();
    return $success ? $insert_id : false;
}

// Get single row
function db_get_one($sql, $params = [], $types = "") {
    $result = db_query($sql, $params, $types);
    return $result->fetch_assoc();
}