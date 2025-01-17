<?php
// Enable error reporting
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Controllers\DonationCartController;
use Controllers\DonationController;
use Controllers\DonorController;
use Controllers\InvoiceController;
use Controllers\PaymentController;
use Models\CashDonation;
use Models\ClothesDonation;
use Models\Command\DonationCart;
use Models\Database;
use Models\Donation;
use Models\Donor;
use Models\DrugsDonation;
use Models\FoodDonation;
use Models\Strategy\Payment;

session_start();
//if (!isset($_SESSION['test'])) {
//    $_SESSION['test'] = "Session is working!";
//} else {
//    echo $_SESSION['test'];
//}

// Include model, controller, and view classes
require_once 'Models/Database.php';
require_once 'Models/Donor.php';
require_once 'Models/Donation.php';
require_once 'Models/CashDonation.php';
require_once 'Models/FoodDonation.php';
require_once 'Models/DrugsDonation.php';
require_once 'Models/ClothesDonation.php';
require_once 'Models/Strategy/Payment.php';
require_once 'Models/Strategy/IPay.php';



require_once 'Controllers/DonorController.php';
require_once 'Controllers/DonationController.php';

require_once 'controllers/InvoiceController.php';
require_once 'Controllers/PaymentController.php';
require_once 'Controllers/DonationCartController.php';


require_once './Views/donorView.php';
require_once './Views/DonorsListView.php';
require_once './Views/UpdateDonorView.php';

require_once './Views/DonationsView.php'; // Add Donations View

require_once './Views/AddCashDonationView.php';
require_once './Views/AddFoodDonationView.php';
require_once './Views/AddDrugsDonationView.php';
require_once './Views/AddClothesDonationView.php';

require_once './Views/PaymentStrategiesView.php';
require_once './Views/CreditCardPaymentView.php';
require_once './Views/PayPalPaymentView.php';
require_once './Views/BankTransferPaymentView.php';
require_once './Views/DonationCartView.php';


// Initialize database connection
$pdo = Database::getInstance();

// Initialize models
$donorModel = new Donor($pdo);  // Assuming `Donor.php` is the Donor model
$donationModel = new Donation($pdo); // Initialize Donation model
$CashDonationModel=new CashDonation($pdo);
$DrugsDonationModel =new DrugsDonation($pdo);
$ClothesDonationModel=new ClothesDonation($pdo);
$FoodDonationModel =new FoodDonation($pdo);
$PaymentModel=new Payment($pdo);



// Initialize controllers
$donorController = new DonorController($donorModel);


$donationController = new DonationController($donationModel);

$InvoiceController = new InvoiceController();
$PaymentController = new PaymentController($PaymentModel);
$DonationCartController =new DonationCartController($donationModel);


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
        // Show all donors
        case 'showAllDonors':
            $donorController->showAll();
            break;

        // Add donor
        case 'addDonor':
            include './views/AddDonorView.php';
            break;

        case 'saveDonor':
            $donorController->saveDonor($_POST);
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

        case 'cashDonation':
            $_SESSION['strategy_type'] = $_GET['action'];
            $donationController->ProcessStrategy($_GET['action']);


            break;


        case 'foodDonation':
            $_SESSION['strategy_type'] = $_GET['action'];
            $donationController->ProcessStrategy($_GET['action']);
            break;


        case 'drugsDonation':
            $_SESSION['strategy_type'] = $_GET['action'];
            $donationController->ProcessStrategy($_GET['action']);
            break;



        case 'clothesDonation':
            $_SESSION['strategy_type'] = $_GET['action'];
            $donationController->ProcessStrategy($_GET['action']);
            break;




        //Add donation to the cart
        case 'addToDonationCart':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $donationType = $_POST['donationType'];
                $quantity = $_POST['Data']; // Ensure this matches your form input name
                $pricePerUnit = $_POST['predefinedAmount'];
                // Ensure the session array exists
                if (!isset($_SESSION['donation_cart'])) {
                    $_SESSION['donation_cart'] = [];
                }

                // Store the donation as an associative array
                $_SESSION['donation_cart'][] = [
                    'donationType' => $donationType,
                    'quantity' => $quantity,
                    'pricePerUnit' => $pricePerUnit,
                    'totalAmount' => $pricePerUnit * $quantity // Automatically calculate total price
                ];
            }

            $DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            echo "success";
            break;

        case 'showCart':
            $view = new \Views\DonationCartView();
            $DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            $view->render();

        case 'removeFromCart':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the session and the index exist
                session_start(); // Ensure session is started
                if (isset($_SESSION['donation_cart']) && isset($_POST['index'])) {
                    $index = (int)$_POST['index']; // Get the index to remove

                    // Remove the item at the specified index
                    if (isset($_SESSION['donation_cart'][$index])) {
                        unset($_SESSION['donation_cart'][$index]); // Remove the donation
                        $_SESSION['donation_cart'] = array_values($_SESSION['donation_cart']); // Re-index the array
                    }
                }

                // Redirect to the cart page or respond with success
                header('Location: index.php?action=showCart');
                exit;
            }
            break;
        case 'undoLastAction':



        case 'redoLastAction':



            break;



        case 'del':
            session_unset();






        case 'proceedToPayment':
            if (isset($_SESSION['strategy_type'])) {
                $strategyType = $_SESSION['strategy_type'];
                $donationController->SaveData($_POST);
            } else {
                echo "Strategy not set. Please choose a donation type.";
            }
            break;





        case 'choosePayment':
            if (isset($_POST['paymentMethod'])) {
                $paymentType = $_POST['paymentMethod'];
                $PaymentController->ProcessStrategy($paymentType);
            } else {
                echo "No payment method selected.";
            }




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




//        case  'addCashDonation':
//            $cashStrategy = new CashDonation($pdo);
//            $donationController->PerformDonation($cashStrategy);
//
//            header("Location: index.php?action=renderAddCashDonation");
//            break;
//
//        case 'renderAddCashDonation':
//            // Render the AddCashDonationView
//            $view = new AddCashDonationView();
//
//            echo $view->render();
//            break;
//
//
//        case 'addCashDonationPayment':
//            {
//                // Save the entered amount in the session
//                $_SESSION['cashDonationAmount'] = $_POST['Amount'];
//
//                // Redirect to the payment page
//                header("Location: index.php?action=showPaymentPage");
//
//                exit;
//            }
//            break;
        case 'showPaymentPage':
            // Retrieve the amount from the session
            $amount = $_SESSION['cashDonationAmount'];

            // Render the payment page with the amount
            echo "<h2>Payment for Donation Amount: $amount</h2>";
        // Render further payment details or a form
            break;



//        case 'cashDonation':
//            $CashDonationController->showAll();
//            break;
//
//        case 'addFoodDonation':
//            $FoodDonationController->add();
//
//        case 'addFoodDonationSubmit':
//            $FoodDonationController->save($_POST);
//            $donationController->saveDonation($_POST);
//
//        case 'Payments':
//            $PaymentController->ShowAll();
//
//
//            break;
//        case 'drugsDonation':
//            $DrugsDonationController->showAll();
//            break;
//        case 'clothesDonation':
//            $ClothesDonationController->showAll();
//            break;

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
