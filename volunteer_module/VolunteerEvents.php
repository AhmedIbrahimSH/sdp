<?php
require_once 'Database.php';

class VolunteerEvents {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a new event for a volunteer
    public function addEvent($personId, $eventName, $eventDate, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteer_events (person_id, event_name, event_date, description)
            VALUES (:person_id, :event_name, :event_date, :description)
        ");
        $stmt->execute([
            'person_id' => $personId,
            'event_name' => $eventName,
            'event_date' => $eventDate,
            'description' => $description
        ]);
    }

    // Retrieve all events for a specific volunteer
    public function getEventsByPersonId($personId) {
        $stmt = $this->db->prepare("
            SELECT event_name, event_date, description
            FROM volunteer_events
            WHERE person_id = :person_id
            ORDER BY event_date ASC
        ");
        $stmt->execute(['person_id' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
