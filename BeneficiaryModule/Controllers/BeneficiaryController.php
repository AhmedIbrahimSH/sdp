<?php
require 'Controllers/NeedController.php';
class BeneficiaryController
{
    private $db;
    private $admin;
    // Constructor to inject the Beneficiary model
    public function __construct($connection, $admin)
    {
        $this->db = $connection;
        $this->admin = $admin;
    }


    public function createBeneficiary()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->admin->CreateBeneficiary($this->db, $_POST);
            // Redirect to the list page after the creation
            // BeneficiaryController::listBeneficiaries();
            // redirect to list_beneficiaries
            header('Location: index.php?action=list_beneficiaries');
        } else {
            // Show the form if not a POST request
            include 'Views/Create_Beneficiary.php';
        }
    }

    public function updateBeneficiary($id)
    {
        // Get the beneficiary data from the model
        $beneficiary = $this->admin->getBeneficiary($this->db, $id);

        // If the form is submitted, update the beneficiary data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Echo the POST data for debugging

            // Update beneficiary with the POST data
            $this->admin->UpdateBeneficiary($this->db, $id, $_POST);
            // Redirect to the list page after the update
            header('Location: index.php?action=list_beneficiaries');
        } else {
            // Use the view class to render the update form
            require_once 'Views/Beneficiary_Update_View.php';
            $view = new UpdateBeneficiaryView();
            $view->render($beneficiary);
        }
    }


    public function deleteBeneficiary()
    {
        $this->admin->DeleteBeneficiary($this->db, $_GET['id']);
        header('Location: index.php?action=list_beneficiaries');
    }

    public function listBeneficiaries()
    {
        $beneficiariesIterator  = $this->admin->getIterator($this->db);

        include 'Views/Beneficiary_List_View.php';
        $view = new Beneficiary_List_View();
        $view->showBeneficiaries($beneficiariesIterator);
    }

    public function show_Beneficiary_profile($id)
    {
        $beneficiary = $this->admin->getBeneficiary($this->db, $id);
        include 'Views/Beneficiary_Profile_View.php';
        $view = new Beneficiary_Profile_View();
        $view->showBeneficiary($beneficiary);
    }

    public function trackDistribution()
    {
        $allocated_data = $this->admin->getAllocatedNeeds($this->db);
        $charity_data = $this->admin->getCharityStorageData($this->db);
        include 'Views/Track_Distribution_View.php';
        $view = new Track_Distribution_View();
        $view->Show_Resource_Distribution($allocated_data, $charity_data);
    }
}
