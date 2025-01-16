<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo 'Current Directory: ' . __DIR__ . PHP_EOL;
// echo 'Full Path: ' . realpath('./NotificationsModule/models/Database.php') . PHP_EOL;
// require_once './NotificationsModule/models/Database.php';



use Controllers\EmailController;
use Models\Database;
use Models\EmailModel;

// require_once __DIR__ . '/NotificationsModule/models/Database.php';
// require_once './NotificationsModule/models/EmailModel.php';
// require_once './NotificationsModule/controllers/EmailController.php';
require_once './Database.php';
require_once './EmailModel.php';
require_once './EmailController.php';
require_once './NotificationsModule/config.php';

$db = Database::getInstance();
$EmailModel= new EmailModel($db);
// Router Logic
if ($_SERVER['REQUEST_URI'] === '/email/form') {
    
    $controller = new EmailController($EmailModel);
    $controller->showForm();
} elseif ($_SERVER['REQUEST_URI'] === '/email/sendEmail') {

    $controller = new EmailController($EmailModel);
    $controller->sendEmail();
} else {
    echo "404 Not Found";
}
