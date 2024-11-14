<?php
class VolunteerTasks {
    private $tasks;

    public function __construct() {
        $this->tasks = []; // Initialize as an empty array
    }

    // Add a new task with optional certificate information
    public function addTask($taskName, $description, $dueDate, $certificate = null) {
        $task = [
            'task_name' => $taskName,
            'description' => $description,
            'due_date' => $dueDate,
            'certificate' => $certificate // Optional certificate associated with the task
        ];
        $this->tasks[] = $task;
    }

    // Add a certificate to a specific task by task name (or by other unique identifier)
    public function addCertificateToTask($taskName, $certificate) {
        foreach ($this->tasks as &$task) {
            if ($task['task_name'] === $taskName) {
                $task['certificate'] = $certificate;
                break;
            }
        }
    }

    // Retrieve all tasks
    public function getTasks() {
        return $this->tasks;
    }
}
?>
