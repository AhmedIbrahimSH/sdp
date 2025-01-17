<?php
namespace models;
use PDO;
require_once 'Database.php';

class VolunteerTasks
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a task for a volunteer
    public function addTask($personId, $taskName, $description, $dueDate)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Tasks (PersonID, task_name, description, due_date)
            VALUES (:personId, :taskName, :description, :dueDate)
        ");
        $stmt->execute([
            'personId' => $personId,
            'taskName' => $taskName,
            'description' => $description,
            'dueDate' => $dueDate
        ]);
    }

    // Get all tasks for a specific volunteer
    public function getTasksByVolunteer($personId)
    {
        $stmt = $this->db->prepare("
            SELECT id AS task_id, task_name, description, due_date
            FROM Tasks
            WHERE PersonID = :personId
            ORDER BY due_date ASC
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a task for a volunteer
    public function updateTask($taskId, $taskName, $description, $dueDate)
    {
        $stmt = $this->db->prepare("
            UPDATE Tasks
            SET task_name = :taskName, description = :description, due_date = :dueDate
            WHERE id = :taskId
        ");
        $stmt->execute([
            'taskName' => $taskName,
            'description' => $description,
            'dueDate' => $dueDate,
            'taskId' => $taskId
        ]);
    }

    // Remove a task for a volunteer
    public function removeTask($taskId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM Tasks
            WHERE id = :taskId
        ");
        $stmt->execute(['taskId' => $taskId]);
    }
}

?>
