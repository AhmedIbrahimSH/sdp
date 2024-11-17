<?php

require_once '../model/notification.php';
require_once '../model/event.php';
require_once '../model/volunteer.php';

// use notify\NotificationController;

//to show php server error and warning add this code :
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$notificationController = new NotificationController();
$notificationController->notifyVolunteers();
