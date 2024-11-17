<?php
require_once '../controller/notification-controller.php';
require_once '../model/event-model.php';
require_once '../model/volunteer-model.php';

// To show PHP server error and warning add this code:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create NotificationController instance
$notificationController = new NotificationController();

// Add volunteers to specific event types
$registrationLog = [];
$notificationLog = [];

$notificationController->addVolunteer("John Doe", "workshop");
$registrationLog[] = "John Doe has been registered for the workshop event.";

$notificationController->addVolunteer("Jane Smith", "fundraiser");
$registrationLog[] = "Jane Smith has been registered for the fundraiser event.";

$notificationController->addVolunteer("Emily Davis", "program");
$registrationLog[] = "Emily Davis has been registered for the program event.";

// Notify subscribers of specific events
$notificationLog[] = [
    "event" => "Workshop Event",
    "message" => "John Doe has been notified about the event: Event: Workshop",
];
$notificationController->notifyVolunteers("workshop");

$notificationLog[] = [
    "event" => "Fundraiser Event",
    "message" => "Jane Smith has been notified about the event: Event: Fundraiser",
];
$notificationController->notifyVolunteers("fundraiser");

$notificationLog[] = [
    "event" => "Program Event",
    "message" => "Emily Davis has been notified about the event: Event: Program",
];
$notificationController->notifyVolunteers("program");
?>