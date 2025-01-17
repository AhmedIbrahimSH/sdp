<?php

require_once '../../EventModule/Model/database_connection.php';

$conn = myDatabase::get_instance();

if (!$conn) {
    die("Connection failed");
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit;
}
file_put_contents("../../debug.log", "okokok started\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

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
