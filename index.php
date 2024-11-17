<?php

// Autoload classes
// include the db
require_once 'Models/Database.php';
require_once 'Models/Beneficiary.php';
//require_once 'Controllers/BeneficiaryController.php';
require_once 'Controllers/BeneficiaryController.php';
require_once 'Controllers/HomeController.php';
require_once 'Models/BeneficiaryAdmin.php';
require_once 'Controllers/NeedController.php';

// Create a new Database instance
// Connect to the database

// Use the Singleton pattern to get the database connection
$db = Database::getInstance()->getConnection();

if (!$db) {
    echo "Error connecting to the database";
    die();
}


// -----------------Admin-----------------
// $sql = "SELECT * FROM Admin WHERE AdminType = 'BeneficiaryAdmin' LIMIT 1";
// $stmt = $db->prepare($sql);
// $stmt->execute();

// $adminData = $stmt->fetch(PDO::FETCH_OBJ);
// -----------------Admin-----------------



// admin object
$admin = new BeneficiaryAdmin();

// Determine the action from the query string
$action = isset($_GET['action']) ? $_GET['action'] : 'list_beneficiaries';

// Instantiate the Beneficiary model
//$beneficiaryModel = new Beneficiary($db);

// Instantiate the BeneficiaryController
$beneficiaryController = new BeneficiaryController($db, $admin);

// Instantiate the NeedController
// Routing logic
switch ($action) {
    case 'create_beneficiary':
        $beneficiaryController->createBeneficiary();
        break;

    case 'track_distribution':
        $beneficiaryController->trackDistribution();
        break;

    case 'update_beneficiary':
        if (isset($_GET['id'])) {
            $beneficiaryController->updateBeneficiary($_GET['id']);
        } else {
            echo "Error: Beneficiary ID not provided";
        }
        break;

    case 'delete_beneficiary':
        if (isset($_GET['id'])) {
            $beneficiaryController->deleteBeneficiary();
        } else {
            echo "Error: Beneficiary ID not provided";
        }
        break;

    case 'list_beneficiaries':
        $beneficiaryController->listBeneficiaries();
        break;


    case 'view_beneficiary':
        if (isset($_GET['id'])) {


            $beneficiaryController->show_Beneficiary_profile($_GET['id']); // this will create my need controller instance 
        } else {
            echo "Error: Beneficiary ID not provided";
        }
        break;

    case 'register_need':
        if (isset($_POST['need_type'], $_POST['amount'], $_POST['beneficiary_id'])) {
            $NeedController = new NeedController($db, $admin, $_POST['beneficiary_id']);
            $NeedController->RequestNeed();
        } else {
            echo "Error: Need type and amount are required";
        }
        break;

    case 'remove_need':
        if (isset($_POST['need_type'], $_POST['beneficiary_id'])) {
            $NeedController = new NeedController($db, $admin, $_POST['beneficiary_id']);
            $NeedController->RemoveNeed();
        } else {
            echo "Error: Need type is required";
        }
        break;

    case 'allocate_resources':
        if (isset($_POST['need_type'], $_POST['beneficiary_id'])) {
            $NeedController = new NeedController($db, $admin, $_POST['beneficiary_id']);
            $NeedController->AllocateResources();
        } else {
            echo "Error: Need type is required";
        }
        break;

    default:
        // Default action can be handled by a HomeController (optional)
        $homeController = new HomeController();
        $homeController->index();
        break;
}
