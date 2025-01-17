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
$EmailModel= new EmailModel($db);
// Router Logic
if ($_SERVER['REQUEST_URI'] === 'NotificationsModule/email/form') {
    
    $controller = new EmailController($EmailModel);
    $controller->showForm();

} elseif ($_SERVER['REQUEST_URI'] === 'NotificationsModule/email/sendEmail') {

    $controller = new EmailController($EmailModel);
    $controller->sendEmail();
} else {
    echo "404 Not Found";
}
