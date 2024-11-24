
<?php

require_once 'database_connection.php';

$conn = Database::get_instance();

if (!$conn) {
    die("Connection failed");
}

class Events {
    public $events_list;
    private $index = 0;


    public function load_events_from_db() {
        global $conn;
        $query = "SELECT EventID, Title , Location, Date, Price , Type FROM events";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $events;
    }
    public function getEvents() {
        $events = $this->load_events_from_db();
        foreach ($events as $row) {
            $this->events_list[$this->index] = $row;
            $this->index++;
        }
        return $this->events_list;
    }
}

?>
