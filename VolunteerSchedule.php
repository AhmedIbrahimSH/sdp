<?php
require_once 'Database.php';

class VolunteerSchedule {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a schedule entry for a volunteer
    public function addScheduleEntry($volunteerId, $scheduleDate, $hours) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteer_schedule (volunteer_id, schedule_date, hours)
            VALUES (:volunteer_id, :schedule_date, :hours)
        ");
        $stmt->execute([
            'volunteer_id' => $volunteerId,
            'schedule_date' => $scheduleDate,
            'hours' => $hours
        ]);
    }

    // Get all schedule entries for a specific volunteer
    public function getScheduleByVolunteerId($volunteerId) {
        $stmt = $this->db->prepare("
            SELECT * FROM volunteer_schedule
            WHERE volunteer_id = :volunteer_id
            ORDER BY schedule_date ASC
        ");
        $stmt->execute(['volunteer_id' => $volunteerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
