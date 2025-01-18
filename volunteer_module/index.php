<?php
use controllers\EventsController;
use controllers\VolunteerCertificateController;
use controllers\VolunteerController;
use controllers\VolunteerScheduleController;
use controllers\VolunteerSkillsController;
use controllers\VolunteerTasksController;

require_once 'controllers/VolunteerController.php';
require_once 'controllers/VolunteerTasksController.php';
require_once 'controllers/VolunteerScheduleController.php';
require_once 'controllers/VolunteerSkillsController.php';
require_once 'controllers/VolunteerCertificateController.php';
require_once 'controllers/EventsController.php';

$volunteerController = new VolunteerController();
$tasksController = new VolunteerTasksController();
$scheduleController = new VolunteerScheduleController();
$skillsController = new VolunteerSkillsController();
$certificateController = new VolunteerCertificateController();
$eventsController = new EventsController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$personId = isset($_GET['person_id']) ? $_GET['person_id'] : null;
$taskId = isset($_GET['task_id']) ? $_GET['task_id'] : null;
$certificateId = isset($_GET['certificate_id']) ? $_GET['certificate_id'] : null;
$eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;

switch ($action) {
    case 'index':
        $volunteerController->index();
        break;
    case 'show_volunteer':
        $volunteerController->show($personId);
        break;
    case 'create_volunteer':
        $volunteerController->create();
        break;
    case 'edit_volunteer':
        $volunteerController->edit($personId);
        break;
    case 'delete_volunteer':
        $volunteerController->delete($personId);
        break;

    case 'volunteer_tasks':
        $tasksController->index($personId);
        break;
    case 'add_task':
        $tasksController->addTask($personId);
        break;
    case 'edit_task':
        $tasksController->editTask($taskId);
        break;
    case 'remove_task':
        $tasksController->removeTask($taskId, $personId);
        break;

    case 'volunteer_schedule':
        $scheduleController->index($personId);
        break;
    case 'add_schedule':
        $scheduleController->addSchedule($personId);
        break;
    case 'edit_schedule':
        $scheduleController->editSchedule($_GET['schedule_id']);
        break;
    case 'remove_schedule':
        $scheduleController->removeSchedule($_GET['schedule_id'], $personId);
        break;

    case 'volunteer_skills':
        $skillsController->index($personId);
        break;
    case 'add_skill':
        $skillsController->addSkill($personId);
        break;
    case 'remove_skill':
        $skillsController->removeSkill($_GET['skill_id'], $personId);
        break;


    case 'task_certificates':
        $certificateController->indexByTask($taskId);
        break;
    case 'volunteer_certificates':
        $certificateController->indexByVolunteer($personId);
        break;
    case 'add_certificate':
        $certificateController->addCertificate($personId);
        break;
    case 'remove_certificate':
        $certificateController->removeCertificate($certificateId, $taskId);
        break;

    case 'events':
        $eventsController->index();
        break;
    case 'show_event':
        $eventsController->show($id);
        break;
    case 'create_event':
        $eventsController->create();
        break;
    case 'subscribe_to_event':
        $volunteerController->subscribeToEvent($eventId);
        break;
    case 'volunteer_subscriptions':
        $volunteerController->manageSubscriptions();
        break;
    case 'edit_event':
        $eventsController->edit($id);
        break;
    case 'delete_event':
        $eventsController->delete($id);
        break;
    case 'assign_volunteer':
        $eventsController->assignVolunteer($id);
        break;
    case 'volunteer_events':
        $eventsController->showVolunteerEvents($personId);
        break;

    default:
        echo "<h1>Page not found</h1>";
        break;
}
?>