<?php
require_once '../Model/database_connection.php';
require_once '../../NotificationsModule/old/subscriber.php';
require_once '../../NotificationsModule/old/publisher.php';
require_once '../View/events_history_view.php';
header('Content-Type: application/json'); // Ensure JSON response

echo 'i am in add event php';
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Display errors

file_put_contents("../../debug.log", "Script started\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $title = isset($input['Title']) ? $input['Title'] : null;
    $location = isset($input['Location']) ? $input['Location'] : null;
    $date = isset($input['Date']) ? $input['Date'] : null;
    $price = isset($input['Price']) ? $input['Price'] : null;
    $type = isset($input['Type']) ? $input['Type'] : null;
    $message = "Event Details:\\n" .
        "Title: $title\\n" .
        "Location: $location\\n" .
        "Date: $date\\n" .
        "Price: $$price\\n" .
        "Type: $type";

    file_put_contents("../../debug.log", $message, FILE_APPEND);



    $logMessage = "[" . date("Y-m-d H:i:s") . "] Extracted values: " . PHP_EOL;
    $logMessage .= "Title: $title" . PHP_EOL;
    $logMessage .= "Location: $location" . PHP_EOL;
    $logMessage .= "Date: $date" . PHP_EOL;
    $logMessage .= "Price: $price" . PHP_EOL;
    $logMessage .= "Type: $type" . PHP_EOL;
    file_put_contents("../../input_data.log", $logMessage, FILE_APPEND);

    // Database connection
    $conn = Database::get_instance();

    // Log a notification message
    $message = "[" . date("Y-m-d H:i:s") . "] Notification: User visited donation types page.";
    file_put_contents("../../notifications.log", $message . PHP_EOL, FILE_APPEND);

    // Prepare and execute the SQL query
    $query = "INSERT INTO events (Title, Location, Date, Price, Type) VALUES (:title, :location, :date, :price, :type)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title); // Ensure placeholder names match
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':type', $type);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
    }

    // Notify subscribers
    $publisher = new publisher($_POST);
    $first_subscriber = new subscriber("ahmed", "fundraiser");
    $second_subscriber = new subscriber("omar", "workshop");

    $publisher->notify($title, $type);
}
?>