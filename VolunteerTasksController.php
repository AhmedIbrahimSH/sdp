<?php
require_once 'VolunteerTasks.php';

class VolunteerTasksController {
    private $volunteerTasksModel;

    public function __construct() {
        $this->volunteerTasksModel = new VolunteerTasks();
    }

    public function addTask($volunteerId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskName = $_POST['task_name'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            // Optional certificate data
            $certificate = null;
            if (!empty($_POST['certificate_name']) && !empty($_POST['date_awarded'])) {
                $certificate = [
                    'certificate_name' => $_POST['certificate_name'],
                    'date_awarded' => $_POST['date_awarded']
                ];
            }

            // Add the task and optional certificate
            $this->volunteerTasksModel->addTask($volunteerId, $taskName, $description, $dueDate, $certificate);

            // Redirect back to the volunteer's details page
            header("Location: index.php?action=show&id=$volunteerId");
            exit;
        } else {
            include 'views/volunteer_add_task.php';
        }
    }


    public function getTasks($volunteerId) {
        return $this->volunteerTasksModel->getTasks($volunteerId);
    }

    public function addCertificate($taskId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $certificateName = $_POST['certificate_name'];
            $dateAwarded = $_POST['date_awarded'];
            $this->volunteerTasksModel->addCertificate($taskId, $certificateName, $dateAwarded);
            header("Location: index.php?action=showTask&id=$taskId");
            exit;
        } else {
            include 'views/volunteer_add_certificate.php';
        }
    }
}
?>
