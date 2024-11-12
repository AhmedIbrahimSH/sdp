<?php

require '../Model/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve JSON input and decode it
    $input = json_decode(file_get_contents('php://input'), true);

    $title = $input['title'];
//    $event_type = $input['event_type'];
    $location = $input['location'];
    $date = $input['date'];
    $price = $input['price'];

    $db_connector = new Database();
    $conn = $db_connector->connect();


    $query = "INSERT INTO events (title, location, date, price) VALUES (:title, :location, :date, :price)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
//    $stmt->bindParam(':event_type', $event_type);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':price', $price);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
    }
}


