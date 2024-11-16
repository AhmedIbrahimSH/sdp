
<?php
require_once 'database_connection.php';

$conn = Database::get_instance();

if (!$conn) {
    die("Connection failed");
}

$query = "SELECT id, title , location, date, price , type FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);

class Events {
    public $events_list;
    private $index = 0;
    public function getEvents() {
        global $events;
        foreach ($events as $row) {
            $this->events_list[$this->index] = $row;
            $this->index++;
        }
        return $this->events_list;
    }
}

?>
