<?php
require 'Volunteer.php';
require 'VolunteerController.php';

// Instantiate the Volunteer model
$volunteerModel = new Volunteer();

// Pass the model instance to the controller
$controller = new VolunteerController($volunteerModel);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($action) {
    case 'show':
        $controller->show($id);
        break;
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
}
?>
