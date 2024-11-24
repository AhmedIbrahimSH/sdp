<?php
require_once 'Database.php';
require_once 'VolunteerObserver.php';
require_once 'EventSubject.php';
class events implements EventSubject {
    private $db;
    private $observers = []; // List of volunteers (observers)
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new event
    public function createEvent($eventName, $eventDate, $Location) {
        $stmt = $this->db->prepare("
            INSERT INTO events (Title, Date, Location)
            VALUES (:eventName, :eventDate, :Location)
        ");
        $stmt->execute([
            'eventName' => $eventName,
            'eventDate' => $eventDate,
            'Location' => $Location
        ]);
        return $this->db->lastInsertId(); // Return the newly created EventID
    }

    // Retrieve an event by ID
    public function getEventById($eventId) {
        $stmt = $this->db->prepare("
            SELECT e.Title, e.Date FROM events as e
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getVolunteersByEventId($eventId) {
        $stmt = $this->db->prepare("
        SELECT 
            v.person_id, 
            p.FirstName, 
            p.LastName
        FROM Volunteer_Events ve
        JOIN Volunteer v ON ve.person_id = v.person_id
        JOIN Person p ON v.person_id = p.person_id
        WHERE ve.event_id = :eventId AND ve.IsVolunteerEventDeleted = 0
    ");
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve all events
    public function getAllEvents() {
        $stmt = $this->db->prepare("
            SELECT * FROM events
            ORDER BY Date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an existing event
    public function updateEvent($eventId, $eventName, $eventDate, $Location) {
        $stmt = $this->db->prepare("
            UPDATE events
            SET Title = :eventName, Date = :eventDate, Location = :Location
            WHERE EventID = :eventId
        ");
        $stmt->execute([
            'eventName' => $eventName,
            'eventDate' => $eventDate,
            'Location' => $Location,
            'eventId' => $eventId
        ]);
    }
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


    // Delete an event
    public function deleteEvent($eventId) {
        $stmt = $this->db->prepare("
            DELETE FROM events
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
    }

    // Associate a volunteer with an event


    // Retrieve all events associated with a volunteer
    public function getEventsByVolunteer($personId) {
        $stmt = $this->db->prepare("
            SELECT e.Title, e.Date, e.Location
            FROM Volunteer_Events ve
            JOIN events e ON ve.event_id = e.EventID
            WHERE ve.person_id = :personId
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Attach an observer (Volunteer) to the events
    public function attach(VolunteerObserver $observer) {
        $this->observers[] = $observer;
    }

    /**
     * Detach an observer from the event.
     *
     * @param VolunteerObserver $observer The observer to detach.
     */
    public function detach(VolunteerObserver $observer) {
        foreach ($this->observers as $key => $subscribedObserver) {
            if ($subscribedObserver === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    /**
     * Notify all observers about the event.
     *
     * @param string $eventType The type of event.
     * @param array $eventDetails Details about the event.
     */
    public function notify($eventType, $eventDetails) {
        foreach ($this->observers as $observer) {
            $observer->update($eventType, $eventDetails, null); // Notify all observers
        }
    }
}
?>
