<?php
// Enable error reporting
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use DonationModule\Controllers\DonationCartController;
use DonationModule\Controllers\DonationController;
use DonationModule\Controllers\DonorController;
use DonationModule\Controllers\InvoiceController;
use DonationModule\Controllers\PaymentController;
use DonationModule\Models\CashDonation;
use DonationModule\Models\ClothesDonation;
use DonationModule\Models\Database;
use DonationModule\Models\Donation;
use DonationModule\Models\Donor;
use DonationModule\Models\DrugsDonation;
use DonationModule\Models\FoodDonation;
use DonationModule\Models\Strategy\Payment;

session_start();
//if (!isset($_SESSION['test'])) {
//    $_SESSION['test'] = "Session is working!";
//} else {
//    echo $_SESSION['test'];
//}

// Include model, controller, and view classes
require_once 'DonationModule/Models/Database.php';
require_once 'DonationModule/Models/Donor.php';
require_once 'DonationModule/Models/Donation.php';
require_once 'DonationModule/Models/CashDonation.php';
require_once 'DonationModule/Models/FoodDonation.php';
require_once 'DonationModule/Models/DrugsDonation.php';
require_once 'DonationModule/Models/ClothesDonation.php';
require_once 'DonationModule/Models/Strategy/Payment.php';
require_once 'DonationModule/Models/Strategy/IPay.php';



require_once 'DonationModule/Controllers/DonorController.php';
require_once 'DonationModule/Controllers/DonationController.php';

require_once 'DonationModule/controllers/InvoiceController.php';
require_once 'DonationModule/Controllers/PaymentController.php';
require_once 'DonationModule/Controllers/DonationCartController.php';


require_once 'DonationModule/Views/donorView.php';
require_once 'DonationModule/Views/DonorsListView.php';
require_once 'DonationModule/Views/UpdateDonorView.php';

require_once 'DonationModule/Views/DonationsView.php'; // Add Donations View

require_once 'DonationModule/Views/AddCashDonationView.php';
require_once 'DonationModule/Views/AddFoodDonationView.php';
require_once 'DonationModule/Views/AddDrugsDonationView.php';
require_once 'DonationModule/Views/AddClothesDonationView.php';

require_once 'DonationModule/Views/PaymentStrategiesView.php';
require_once 'DonationModule/Views/CreditCardPaymentView.php';
require_once 'DonationModule/Views/PayPalPaymentView.php';
require_once 'DonationModule/Views/BankTransferPaymentView.php';
require_once 'DonationModule/Views/DonationCartView.php';


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
            include 'DonationModule/views/AddDonorView.php';
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





        case 'addToDonationCart':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $donationType = $_POST['donationType'];
                $quantity = $_POST['Data'];
                $pricePerUnit = $_POST['predefinedAmount'];

                if (!isset($_SESSION['donation_cart'])) {
                    $_SESSION['donation_cart'] = [];
                }

                $_SESSION['donation_cart'][] = [
                    'donationType' => $donationType,
                    'quantity' => $quantity,
                    'pricePerUnit' => $pricePerUnit,
                    'totalAmount' => $pricePerUnit * $quantity


                ];
            }

            $donations=$_SESSION['donation_cart'];
            foreach ($donations as $donation) {
                $donationController->Modelsaver($donation['donationType'],
                    $donation['quantity'],
                    $donation['pricePerUnit']);

                $DonationCartController->AddDonationToCart($donationController->ModelReturner());
            }


//            $latestDonation = end($_SESSION['donation_cart']);
//            $donationController->Modelsaver($latestDonation['donationType'],
//                $latestDonation['quantity'],
//                $latestDonation['pricePerUnit']);
//
//
//            $DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            echo "success";
            break;

        case 'showCart':
            $view = new \DonationModule\Views\DonationCartView();
            //$DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            $donations=$_SESSION['donation_cart'];
            foreach ($donations as $donation) {
                $donationController->Modelsaver($donation['donationType'],
                    $donation['quantity'],
                    $donation['pricePerUnit']);
                $DonationCartController->AddDonationToCart($donationController->ModelReturner());
            }
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
          //  $donationController;
            $DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            $DonationCartController->setCommandfromView();
            $DonationCartController->undoclicked();



        case 'redoLastAction':
            $DonationCartController->AddDonationToCart($_SESSION['donation_cart']);
            $DonationCartController->setCommandfromView();
            $DonationCartController->redoclicked();
            break;



        case 'del':
            session_unset();


        case 'proceedToPayment':
            if (isset($_SESSION['strategy_type'])) {
                $strategyType = $_SESSION['strategy_type'];

                foreach ($_SESSION['donation_cart'] as $donation) {
                    $totalCartAmount += $donation['totalAmount'];
                }
                $donationController->SaveData($_POST,$totalCartAmount);
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
            foreach ($_SESSION['donation_cart'] as $donation) {
                $totalCartAmount += $donation['totalAmount'];
            }

            // Render the payment page with the amount
            echo "<h2>Payment for Donation Amount: $totalCartAmount</h2>";
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
