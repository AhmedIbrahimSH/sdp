<?php
require_once 'Database.php';

class VolunteerSchedule {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a schedule item for a volunteer
    public function addScheduleItem($personId, $scheduleDate, $hours) {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Schedule (person_id, schedule_date, hours)
            VALUES (:personId, :scheduleDate, :hours)
        ");
        $stmt->execute([
            'personId' => $personId,
            'scheduleDate' => $scheduleDate,
            'hours' => $hours
        ]);
    }

    // Get all schedule items for a specific volunteer
    public function getScheduleByVolunteer($personId) {
        $stmt = $this->db->prepare("
            SELECT id AS schedule_id, schedule_date, hours
            FROM Volunteer_Schedule
            WHERE person_id = :personId
            ORDER BY schedule_date ASC
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a schedule item
    public function updateScheduleItem($scheduleId, $scheduleDate, $hours) {
        $stmt = $this->db->prepare("
            UPDATE Volunteer_Schedule
            SET schedule_date = :scheduleDate, hours = :hours
            WHERE id = :scheduleId
        ");
        $stmt->execute([
            'scheduleDate' => $scheduleDate,
            'hours' => $hours,
            'scheduleId' => $scheduleId
        ]);
    }

    // Remove a schedule item
    public function removeScheduleItem($scheduleId) {
        $stmt = $this->db->prepare("
            DELETE FROM Volunteer_Schedule
            WHERE id = :scheduleId
        ");
        $stmt->execute(['scheduleId' => $scheduleId]);
    }
}
?>
