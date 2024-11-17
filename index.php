<?php
session_start();

// Include model, controller, and view classes
require_once 'Models/Database.php';
require_once 'Models/Donor.php';
require_once 'Models/Donation.php';
require_once 'Models/CashDonation.php';
require_once 'Models/FoodDonation.php';
require_once 'Models/DrugsDonation.php';
require_once 'Models/ClothesDonation.php';

require_once 'Controllers/DonorController.php';
require_once 'Controllers/DonationController.php';
require_once 'Controllers/CashDonationController.php';
require_once 'Controllers/FoodDonationController.php';
require_once 'Controllers/DrugsDonationController.php';
require_once 'Controllers/ClothesDonationController.php';
require_once 'controllers/InvoiceController.php';

require_once 'Views/donorView.php';
require_once 'Views/DonorsListView.php';
require_once 'Views/UpdateDonorView.php';

require_once 'Views/DonationsView.php'; // Add Donations View
require_once 'Views/CashDonationView.php';
require_once 'Views/FoodDonationView.php';
require_once 'Views/DrugsDonationView.php';
require_once 'Views/ClothesDonationView.php';
require_once 'Views/AddCashDonationView.php';



// Initialize database connection
$pdo = Database::getInstance();

// Initialize models
$donorModel = new Donor($pdo);  // Assuming `Donor.php` is the Donor model
$donationModel = new Donation($pdo); // Initialize Donation model
$CashDonationModel=new CashDonation($pdo);
$DrugsDonationModel =new DrugsDonation($pdo);
$ClothesDonationModel=new ClothesDonation($pdo);
$FoodDonationModel =new FoodDonation($pdo);


// Initialize controllers
$donorController = new DonorController($donorModel);
$donationController = new DonationController($donationModel);
$CashDonationController = new CashDonationController($CashDonationModel);
$FoodDonationController = new FoodDonationController($FoodDonationModel);
$DrugsDonationController = new DrugsDonationController($DrugsDonationModel);
$ClothesDonationController = new ClothesDonationController($ClothesDonationModel);
$InvoiceController = new InvoiceController();

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

        case 'editDonor':
            // Load donor edit form
            if (isset($_GET['id'])) {
                try {
                    $donorController->edit($_GET['id']);

                } catch (Exception $e) {

                }
            } else {
                echo "Donor ID not provided.";
            }
            break;

        case 'updateDonor':

            // Update donor details
            if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $donorController->update($_GET['id'], $_POST);
                } catch (Exception $e) {

                }
            } else {
                echo "Invalid request.";
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

        ##############DONATIONS
        case 'showAllDonations':
            // Show all donations
            $donationController->showAll();
            break;

        case 'addDonation':
            $donationController->DonationTypes();
            // Render add donation form
            break;

        case 'saveDonation':
            // Save a new donation
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $donationController->saveDonation($_POST);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "Invalid request.";
            }
            break;

        case 'updateDonation':
            // Update donation details
            if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $donationController->update($_GET['id'], $_POST);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "Invalid request.";
            }
            break;

        case 'deleteDonation':
            // Delete a donation
            if (isset($_GET['id'])) {
                $donationController->delete($_GET['id']);
            } else {
                echo "Donation ID not provided.";
            }
            break;


        case 'editDonation':
            // Load donation edit form
            if (isset($_GET['id'])) {
                try {
                    $donationController->edit($_GET['id']);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "Donation ID not provided.";
            }
            break;



        case  'addCashDonation':
            $cashStrategy = new CashDonation($pdo);
            $donationController->PerformDonation($cashStrategy);

            header("Location: index.php?action=renderAddCashDonation");
            break;

        case 'renderAddCashDonation':
            // Render the AddCashDonationView
            $view = new AddCashDonationView();

            echo $view->render();
            break;


        case 'addCashDonationPayment':
            {
                // Save the entered amount in the session
                $_SESSION['cashDonationAmount'] = $_POST['Amount'];

                // Redirect to the payment page
                header("Location: index.php?action=showPaymentPage");

                exit;
            }
            break;
        case 'showPaymentPage':
            // Retrieve the amount from the session
            $amount = $_SESSION['cashDonationAmount'];

            // Render the payment page with the amount
            echo "<h2>Payment for Donation Amount: $amount</h2>";
        // Render further payment details or a form
            break;



        case 'cashDonation':
            $CashDonationController->showAll();
            break;

        case 'addFoodDonation':
            $FoodDonationController->add();

        case 'addFoodDonationSubmit':
            $FoodDonationController->save($_POST);
            $donationController->saveDonation($_POST);




            break;
        case 'drugsDonation':
            $DrugsDonationController->showAll();
            break;
        case 'clothesDonation':
            $ClothesDonationController->showAll();
            break;

        case 'invoice':

            $InvoiceController->showInvoice(1); // Example: Show invoice with ID 1
            break;

        default:
            echo "Unknown action: " . htmlspecialchars($_GET['action']);
            break;
    }
} else {
    echo "No action specified.";
}
