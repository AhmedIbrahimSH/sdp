<?php
require_once '../Model/database_connection.php';
require_once '../../NotificationsModule/subscriber.php';
require_once '../../NotificationsModule/publisher.php';
require_once '../view/events_history_view.php';
header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $title = isset($input['title']) ? $input['title'] : null;
    $location = isset($input['location']) ? $input['location'] : null;
    $date = isset($input['date']) ? $input['date'] : null;
    $price = isset($input['price']) ? $input['price'] : null;
    $type = isset($input['type']) ? $input['type'] : null;


    $conn = Database::get_instance();

    $query = "INSERT INTO events (Title, Location, Date, Price, Type) VALUES (:title, :location, :date, :price, :type)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':Title', $title);
    $stmt->bindParam(':Location', $location);
    $stmt->bindParam(':Date', $date);
    $stmt->bindParam(':Price', $price);
    $stmt->bindParam(':Type', $type);

    if ($stmt->execute()) {
//        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
    }

    $publisher = new publisher($_POST);
    $first_subscriber = new subscriber("ahmed", "fundraiser");
    $second_subscriber = new subscriber("omar", "workshop");

    $publisher->notify($title, $type);



}


