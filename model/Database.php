<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'event_management');

/**
 * Establishes database connection
 * @return mysqli|false Returns connection object or false on failure
 */
function db_connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        error_log("Database connection error: " . mysqli_connect_error());
        return false;
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}

/**
 * Executes a query with parameters
 * @param string $sql The SQL query
 * @param array $params Parameters to bind
 * @param string $types Parameter types (e.g., "ssi")
 * @return mysqli_result|false Returns result object or false on failure
 */
function db_query($sql, $params = [], $types = "") {
    $conn = db_connect();
    if (!$conn) return false;
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        mysqli_close($conn);
        return false;
    }
    
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    return $result;
}

/**
 * Inserts data and returns the insert ID
 * @param string $sql The INSERT SQL query
 * @param array $params Parameters to bind
 * @param string $types Parameter types
 * @return int|false Returns insert ID or false on failure
 */
function db_insert($sql, $params = [], $types = "") {
    $conn = db_connect();
    if (!$conn) return false;
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        mysqli_close($conn);
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $insert_id = mysqli_stmt_insert_id($stmt);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    return $insert_id;
}

/**
 * Updates data in the database
 * @param string $sql The UPDATE SQL query
 * @param array $params Parameters to bind
 * @param string $types Parameter types
 * @return bool Returns true on success, false on failure
 */
function db_update($sql, $params = [], $types = "") {
    $conn = db_connect();
    if (!$conn) return false;
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        mysqli_close($conn);
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    $success = mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    return $success;
}

/**
 * Deletes data from the database
 * @param string $sql The DELETE SQL query
 * @param array $params Parameters to bind
 * @param string $types Parameter types
 * @return bool Returns true on success, false on failure
 */
function db_delete($sql, $params = [], $types = "") {
    return db_update($sql, $params, $types);
}