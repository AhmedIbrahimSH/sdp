<?php
require_once 'VolunteerController.php';
require_once 'VolunteerSkillsController.php';
require_once 'VolunteerScheduleController.php';
require_once 'VolunteerTasksController.php';
require_once 'VolunteerCertificatesController.php';  // Include VolunteerCertificatesController

$volunteerController = new VolunteerController();
$skillsController = new VolunteerSkillsController();
$scheduleController = new VolunteerScheduleController();
$tasksController = new VolunteerTasksController();
$certificateController = new VolunteerCertificatesController();  // Instantiate VolunteerCertificatesController

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($action) {
    case 'show':
        $volunteerController->show($id);
        break;
    case 'create':
        $volunteerController->create();
        break;
    case 'update':
        $volunteerController->update($id);
        break;
    case 'delete':
        $volunteerController->delete($id);
        break;
    case 'addSkill':
        $skillsController->addSkill($id);
        break;
    case 'addSchedule':
        $scheduleController->addSchedule($id);
        break;
    case 'addTask':
        $tasksController->addTask($id);
        break;
    case 'addCertificate':
        $certificateController->addCertificate($_GET['task_id']);  // Use the certificate controller
        break;
    default:
        $volunteerController->index();
}
?>
