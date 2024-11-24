<?php
// Require all necessary controllers
require_once 'VolunteerController.php';
require_once 'VolunteerTasksController.php';
require_once 'VolunteerScheduleController.php';
require_once 'VolunteerSkillsController.php';
require_once 'VolunteerCertificateController.php';
require_once 'EventsController.php';

// Instantiate all controllers
$volunteerController = new VolunteerController();
$tasksController = new VolunteerTasksController();
$scheduleController = new VolunteerScheduleController();
$skillsController = new VolunteerSkillsController();
$certificateController = new VolunteerCertificateController();
$eventsController = new EventsController();

// Determine the action from the query string
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Determine the relevant IDs from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;
$personId = isset($_GET['person_id']) ? $_GET['person_id'] : null;
$taskId = isset($_GET['task_id']) ? $_GET['task_id'] : null;
$certificateId = isset($_GET['certificate_id']) ? $_GET['certificate_id'] : null;
$eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;
// Routing logic
switch ($action) {
    // Volunteer-related actions
    case 'index': // Show all volunteers
        $volunteerController->index();
        break;
    case 'show_volunteer': // Show details for a specific volunteer
        $volunteerController->show($personId);
        break;
    case 'create_volunteer': // Add a new volunteer
        $volunteerController->create();
        break;
    case 'edit_volunteer': // Edit a volunteer's details
        $volunteerController->edit($personId);
        break;
    case 'delete_volunteer': // Delete a volunteer
        $volunteerController->delete($personId);
        break;

    // Task-related actions
    case 'volunteer_tasks': // Show tasks for a specific volunteer
        $tasksController->index($personId);
        break;
    case 'add_task': // Add a task to a volunteer
        $tasksController->addTask($personId);
        break;
    case 'edit_task': // Edit a task for a volunteer
        $tasksController->editTask($taskId);
        break;
    case 'remove_task': // Remove a task from a volunteer
        $tasksController->removeTask($taskId, $personId);
        break;

    // Schedule-related actions
    case 'volunteer_schedule': // Show schedule for a specific volunteer
        $scheduleController->index($personId);
        break;
    case 'add_schedule': // Add a schedule item for a volunteer
        $scheduleController->addSchedule($personId);
        break;
    case 'edit_schedule': // Edit a schedule item for a volunteer
        $scheduleController->editSchedule($_GET['schedule_id']);
        break;
    case 'remove_schedule': // Remove a schedule item for a volunteer
        $scheduleController->removeSchedule($_GET['schedule_id'], $personId);
        break;

    // Skill-related actions
    case 'volunteer_skills': // Show skills for a specific volunteer
        $skillsController->index($personId);
        break;
    case 'add_skill': // Add a skill to a volunteer
        $skillsController->addSkill($personId);
        break;
    case 'remove_skill': // Remove a skill from a volunteer
        $skillsController->removeSkill($_GET['skill_id'], $personId);
        break;

    // Certificate-related actions
    case 'task_certificates': // Show certificates for a specific task
        $certificateController->indexByTask($taskId);
        break;
    case 'volunteer_certificates': // Show certificates for a specific volunteer
        $certificateController->indexByVolunteer($personId);
        break;
    case 'add_certificate': // Add a certificate to a task
        $certificateController->addCertificate($taskId);
        break;
    case 'remove_certificate': // Remove a certificate
        $certificateController->removeCertificate($certificateId, $taskId);
        break;

    // Event-related actions
    case 'events': // Show all events
        $eventsController->index();
        break;
    case 'show_event': // Show details for a specific event
        $eventsController->show($id);
        break;
    case 'create_event': // Add a new event
        $eventsController->create();
        break;
    case 'subscribe_to_event':
        $volunteerController->subscribeToEvent($eventId);
        break;
    case 'volunteer_subscriptions':
        $volunteerController->manageSubscriptions();
        break;
    case 'edit_event': // Edit an event
        $eventsController->edit($id);
        break;
    case 'delete_event': // Delete an event
        $eventsController->delete($id);
        break;
    case 'assign_volunteer': // Assign a volunteer to an event
        $eventsController->assignVolunteer($id);
        break;
    case 'volunteer_events': // Show events for a specific volunteer
        $eventsController->showVolunteerEvents($personId);
        break;

    default:
        echo "<h1>Page not found</h1>";
        break;
}
?>
