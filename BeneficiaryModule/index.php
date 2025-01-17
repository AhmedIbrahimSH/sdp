<?php
require_once 'Models/Database.php';
require_once 'Models/Beneficiary.php';
require_once 'Controllers/BeneficiaryController.php';
require_once 'Models/BeneficiaryAdmin.php';
require_once 'Controllers/NeedController.php';


// Use the Singleton pattern to get the database connection
$db = Database::getInstance()->getConnection();

if (!$db) {
    echo "Error connecting to the database";
    die();
}

// admin object
$admin = new BeneficiaryAdmin($db);

// Instantiate the BeneficiaryController
$beneficiaryController = new BeneficiaryController($db, $admin);

// Determine the action from the query string
$action = isset($_GET['action']) ? $_GET['action'] : 'list_beneficiaries';
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
        //$beneficiaryController->listBeneficiaries();
        echo "Default Not supposed to be shown";
        break;
}
