<?php


require_once __DIR__ . '/../model/notification-model.php';
require_once __DIR__ . '/../model/event-model.php';
require_once __DIR__ . '/../model/volunteer-model.php';
require_once __DIR__ . '/../controller/notification-controller.php';
// use notify\NotificationController;

//to show php server error and warning add this code :
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$notificationController = new NotificationController();
$notificationController->notifyVolunteers();
