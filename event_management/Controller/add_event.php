<?php
require_once '../Model/database_connection.php';
require_once '../../notifications/subscriber.php';
require_once '../../notifications/publisher.php';
require_once '../view/events_history_view.php';
header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Check if decoding was successful
//    if (is_null($input)) {
//        echo json_encode(['success' => false, 'message' => 'No JSON data received']);
//        exit;
//    }

    // Extract fields with null check
    $title = isset($input['title']) ? $input['title'] : null;
    $location = isset($input['location']) ? $input['location'] : null;
    $date = isset($input['date']) ? $input['date'] : null;
    $price = isset($input['price']) ? $input['price'] : null;
    $type = isset($input['type']) ? $input['type'] : null;


    $conn = Database::get_instance();

    $query = "INSERT INTO events (title, location, date, price, type) VALUES (:title, :location, :date, :price, :type)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':type', $type);

    if ($stmt->execute()) {
//        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
    }

    $publisher = new publisher($_POST);
    $subscriber = new subscriber("ahmed", "fundraiser");
    $secsub = new subscriber("omar", "workshop");

    $publisher->notify($title, $type);



}


