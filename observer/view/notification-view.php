<?php

require_once '../controller/notification-controller.php';
require_once '../model/event-model.php';
require_once '../model/volunteer-model.php';

// use notify\NotificationController;

//to show php server error and warning add this code :
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$notificationController = new NotificationController();
$notificationController->notifyVolunteers();
