<?php

namespace models;

require_once 'Database.php';
require_once 'VolunteerObserver.php';
require_once 'EventSubject.php';

class Event implements EventSubject
{
    private $db;
    private $observers = [];

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createEvent($eventName, $eventDate, $Location)
    {
        $stmt = $this->db->prepare("
            INSERT INTO events (Title, Date, Location)
            VALUES (:eventName, :eventDate, :Location)
        ");
        $stmt->execute([
            'eventName' => $eventName,
            'eventDate' => $eventDate,
            'Location' => $Location
        ]);
        return $this->db->lastInsertId();
    }

    public function getEventById($eventId)
    {
        $stmt = $this->db->prepare("
            SELECT e.Title, e.Date FROM events as e
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVolunteersByEventId($eventId)
    {
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
    public function getAllEvents()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM events
            ORDER BY Date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateEvent($eventId, $eventName, $eventDate, $Location)
    {
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

    public function assignVolunteerToEvent($personId, $eventId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Events (person_id, event_id)
            VALUES (:personId, :eventId)
        ");
        $stmt->execute([
            'personId' => $personId,
            'eventId' => $eventId
        ]);
    }


    public function deleteEvent($eventId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM events
            WHERE EventID = :eventId
        ");
        $stmt->execute(['eventId' => $eventId]);
    }



    public function getEventsByVolunteer($personId)
    {
        $stmt = $this->db->prepare("
            SELECT e.Title, e.Date, e.Location
            FROM Volunteer_Events ve
            JOIN events e ON ve.event_id = e.EventID
            WHERE ve.person_id = :personId
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function attach(VolunteerObserver $observer)
    {
        $this->observers[] = $observer;
    }
    public function detach(VolunteerObserver $observer)
    {
        foreach ($this->observers as $key => $subscribedObserver) {
            if ($subscribedObserver === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    public function notify($eventType, $eventDetails)
    {
        foreach ($this->observers as $observer) {
            $observer->update($eventType, $eventDetails, null); // Notify all observers
        }
    }
}

?>
