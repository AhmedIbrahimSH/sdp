<?php
namespace models;
use PDO;
require_once 'Database.php';

class VolunteerSchedule
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addScheduleItem($personId, $scheduleDate, $hours)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Schedule (PersonID, schedule_date, hours)
            VALUES (:personId, :scheduleDate, :hours)
        ");
        $stmt->execute([
            'personId' => $personId,
            'scheduleDate' => $scheduleDate,
            'hours' => $hours
        ]);
    }

    public function getScheduleByVolunteer($personId)
    {
        $stmt = $this->db->prepare("
            SELECT id AS schedule_id, schedule_date, hours
            FROM Schedule
            WHERE PersonID = :personId
            ORDER BY schedule_date ASC
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateScheduleItem($scheduleId, $scheduleDate, $hours)
    {
        $stmt = $this->db->prepare("
            UPDATE Schedule
            SET schedule_date = :scheduleDate, hours = :hours
            WHERE id = :scheduleId
        ");
        $stmt->execute([
            'scheduleDate' => $scheduleDate,
            'hours' => $hours,
            'scheduleId' => $scheduleId
        ]);
    }

    public function removeScheduleItem($scheduleId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM Schedule
            WHERE id = :scheduleId
        ");
        $stmt->execute(['scheduleId' => $scheduleId]);
    }
}

?>
