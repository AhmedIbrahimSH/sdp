
<?php
require 'database_connection.php';

// Create a Database object and establish a connection
$db_connector = new Database();
$conn = $db_connector->connect();

if (!$conn) {
    die("Connection failed");
}

$query = "SELECT id, title , location, date, price FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
?>
