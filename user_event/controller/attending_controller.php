<?php

require_once '../../EventModule/Model/database_connection.php';

$conn = myDatabase::get_instance();

if (!$conn) {
    die("Connection failed");
}
// Handle preflight request for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit; // No need to process further, just respond to preflight
}

// Handle normal POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    // Your database and logic code here
    require_once '../../EventModule/Model/database_connection.php';
    $conn = myDatabase::get_instance();

    if (!$conn) {
        die("Connection failed");
    }

    function attendEvent() {
        global $conn;
        $inputData = json_decode(file_get_contents('php://input'), true);

        if ($inputData && isset($inputData['attend']) && $inputData['attend'] === 'true' && isset($inputData['event_id'])) {
            $event_id = $inputData['event_id'];
            $user_id = $inputData['user_id'];
            $query = "INSERT INTO user_attendees (user_id, event_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt->execute([$user_id, $event_id])) {
                echo "success";
            } else {
                echo "Error registering for the event.";
            }
        }
    }

    attendEvent();
}

?>
