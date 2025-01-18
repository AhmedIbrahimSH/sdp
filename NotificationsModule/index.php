<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Controllers\EmailController;
use Models\Database;
use Models\EmailModel;


require_once 'models/Database.php';
require_once 'models/EmailModel.php';
require_once 'controllers/EmailController.php';
require_once 'config.php';

$db = Database::getInstance();
$EmailModel = new EmailModel($db);
$controller = new EmailController($EmailModel);


// Get the current action from $_SERVER['REQUEST_URI']
$action = $_SERVER['REQUEST_URI'];

// Define switch-case routing logic
switch ($action) {
    case '/NotificationsModule/email/form':
        $controller->showForm();
        break;

    case '/NotificationsModule/email/sendEmail':
        $controller->sendEmail();
        break;

    default:
        echo "404 Not Found";
        break;
}
