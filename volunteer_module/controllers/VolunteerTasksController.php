<?php

namespace controllers;

use models\VolunteerTasks;

require_once  __DIR__  . '/../models/VolunteerTasks.php';

class VolunteerTasksController
{
    private $volunteerTasksModel;

    public function __construct()
    {
        $this->volunteerTasksModel = new VolunteerTasks();
    }

    public function index($personId)
    {
        $tasks = $this->volunteerTasksModel->getTasksByVolunteer($personId);
        include __DIR__  . '/../views/volunteer_tasks_list.php';
    }

    public function addTask($personId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskName = $_POST['task_name'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];
            $this->volunteerTasksModel->addTask($personId, $taskName, $description, $dueDate);
            header("Location: index.php?action=volunteer_tasks&person_id=$personId");
            exit;
        } else {
            $tasks = $this->volunteerTasksModel->getTasksByVolunteer($personId);
            include __DIR__  . '/../views/volunteer_add_task.php'; // Show the task creation form
        }
    }

    public function editTask($taskId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskName = $_POST['task_name'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            $this->volunteerTasksModel->updateTask($taskId, $taskName, $description, $dueDate);

            header("Location: index.php?action=volunteer_tasks&person_id=" . $_POST['person_id']);
            exit;
        } else {
            $task = $this->volunteerTasksModel->getTasksByVolunteer($_GET['person_id']);
            include __DIR__  . '/../views/volunteer_edit_task.php'; // Show the task editing form
        }
    }

    public function removeTask($taskId, $personId)
    {
        $this->volunteerTasksModel->removeTask($taskId);

        header("Location: index.php?action=volunteer_tasks&person_id=$personId");
        exit;
    }
}

?>
