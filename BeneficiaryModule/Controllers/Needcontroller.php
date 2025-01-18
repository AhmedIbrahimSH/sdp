<?php

use Controllers\EmailController;
use Models\EmailModel;

class NeedController
{

    private $db;
    private $admin;
    private $beneficiary;

    public function __construct($connection, $admin, $beneficiaryID)
    {
        $this->db = $connection;
        $this->admin = $admin;
        $this->beneficiary = $this->admin->getBeneficiary($this->db, $beneficiaryID);
    }


    public function RequestNeed()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure both need type and amount are provided
            if (isset($_POST['need_type'], $_POST['amount'])) {
                $needType = $_POST['need_type'];
                $amount = $_POST['amount'];

                // Call the admin method to register the new need
                $this->beneficiary->RequestNeed($needType, $amount);

                // Redirect back to the beneficiary profile view after success
                header('Location: index.php?action=view_beneficiary&id=' . urlencode($_POST['beneficiary_id']));
                exit();
            } else {
                // If data is incomplete, reload the form with an error message
                echo "Need type and amount are required.";
                //include 'Views/Create_Need.php';
            }
        }
    }

    public function AllocateResources()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $needType = $_POST['need_type'];
            $beneficiaryID = $_POST['beneficiary_id'];
            $status = $this->beneficiary->SupportNeed($needType, $beneficiaryID);
            if ($status == "success") {
                // send mail

                require_once __DIR__ . '/../../NotificationsModule/Controllers/EmailController.php';
                require_once __DIR__ . '/../../NotificationsModule/Models/EmailModel.php';

                $emailModel = new EmailModel($this->db);
                $emailController = new EmailController($emailModel);

                $emailController->showForm();
                session_start();

                $_SESSION['beneficiary_id'] = $beneficiaryID;
            }
            // header('Location: index.php?action=view_beneficiary&id=' . urlencode($_POST['beneficiary_id']));
            // exit();
        } else {
            echo "Error: Need type is required";
        }
    }



    public function RemoveNeed()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $needType = $_POST['need_type'];
            $need_id = $_POST['AllocationID'];
            $BeneficiaryID = $_POST['beneficiary_id'];
            $this->beneficiary->RemoveNeed($this->db, $needType, $BeneficiaryID, $need_id);
            header('Location: index.php?action=view_beneficiary&id=' . urlencode($_POST['beneficiary_id']));
            exit();
        }
    }
}
