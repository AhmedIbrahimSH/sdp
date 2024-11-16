<?php
require_once 'Database.php';

class Event {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new event
    public function createEvent($eventName, $eventDate, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO Event (EventName, EventDate, Description)
            VALUES (:eventName, :eventDate, :description)
        ");
        $stmt->execute([
            'eventName' => $eventName,
            'eventDate' => $eventDate,
            'description' => $description
        ]);
        return $this->db->lastInsertId(); // Return the newly created EventID
    }

    // Retrieve an event by ID
    public function getEventById($eventId) {
        $stmt = $this->db->prepare("
            SELECT * FROM Event
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retrieve all events
    public function getAllEvents() {
        $stmt = $this->db->prepare("
            SELECT * FROM Event
            ORDER BY EventDate ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an existing event
    public function updateEvent($eventId, $eventName, $eventDate, $description) {
        $stmt = $this->db->prepare("
            UPDATE Event
            SET EventName = :eventName, EventDate = :eventDate, Description = :description
            WHERE EventID = :eventId
        ");
        $stmt->execute([
            'eventName' => $eventName,
            'eventDate' => $eventDate,
            'description' => $description,
            'eventId' => $eventId
        ]);
    }

    // Delete an event
    public function deleteEvent($eventId) {
        $stmt = $this->db->prepare("
            DELETE FROM Event
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
    }

    // Associate a volunteer with an event
    public function assignVolunteerToEvent($personId, $eventId) {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Events (person_id, event_id)
            VALUES (:personId, :eventId)
        ");
        $stmt->execute([
            'personId' => $personId,
            'eventId' => $eventId
        ]);
    }

    // Retrieve all events associated with a volunteer
    public function getEventsByVolunteer($personId) {
        $stmt = $this->db->prepare("
            SELECT e.EventName, e.EventDate, e.Description
            FROM Volunteer_Events ve
            JOIN Event e ON ve.event_id = e.EventID
            WHERE ve.person_id = :personId
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
