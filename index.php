<?php

// Include model, controller, and view classes
require_once 'Models/Database.php';
require_once 'Models/Donor.php';
require_once 'Controllers/DonorController.php';
require_once 'Views/donorView.php';
require_once 'Views/DonorsListView.php';

// Initialize database connection
$pdo = Database::getInstance();

// Initialize models
$donorModel = new Donor($pdo);  // Assuming `Donor.php` is the Donor model

// Initialize controllers
$donorController = new DonorController($donorModel);

// Check the action parameter to determine the requested action
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'showDonor':
            // Show a single donor
            if (isset($_GET['id'])) {
                $donorController->show($_GET['id']);
            } else {
                echo "Donor ID not provided.";
            }
            break;

        case 'showAllDonors':
            // Show all donors

            $donorController->showAll();
            break;

        case 'addDonor':
            include 'views/AddDonorView.php';
            break;
        case 'saveDonor':
            $db = Database::getInstance(); // Ensure Database class is included
            $model = new Donor($db);
            $controller = new DonorController($model);
            $controller->saveDonor($_POST);
            break;

        case 'updateDonor':
            // Update an existing donor (assuming data is sent via POST)
            if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $donorController->update($_GET['id'], $_POST);
            } else {
                echo "Donor ID not provided or invalid request method for updating a donor.";
            }
            break;

        case 'deleteDonor':
            // Delete a donor
            if (isset($_GET['id'])) {
                $donorController->delete($_GET['id']);
            } else {
                echo "Donor ID not provided.";
            }
            break;

        default:
            echo "Unknown action: " . htmlspecialchars($_GET['action']);
            break;
    }
} else {
    echo "No action specified.";
}
