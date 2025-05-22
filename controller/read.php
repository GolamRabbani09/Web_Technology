<?php
require_once __DIR__ . '/../model/mydb.php';

function get_events() {
    $sql = "SELECT * FROM events ORDER BY event_date DESC";
    $result = db_query($sql);
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    return $events;
}

// Return JSON for API calls
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    echo json_encode(get_events());
    exit();
}