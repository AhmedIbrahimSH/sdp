<?php

use models\Database;

require_once 'database_connection.php';

$conn = Database::get_instance();

if (!$conn) {
    die("Connection failed");
}

$query = "SELECT EventID, Title , Location, Date, Price , type FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
