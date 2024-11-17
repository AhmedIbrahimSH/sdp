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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Event Notifications</h1>

        <!-- Registration Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Volunteer Registrations
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($registrationLog as $registration): ?>
                        <li class="list-group-item"><?= $registration; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="card">
            <div class="card-header bg-success text-white">
                Notifications
            </div>
            <div class="card-body">
                <?php foreach ($notificationLog as $notification): ?>
                    <div class="alert alert-info" role="alert">
                        <strong>Sending notifications for <?= $notification['event']; ?>:</strong>
                        <p><?= $notification['message']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
