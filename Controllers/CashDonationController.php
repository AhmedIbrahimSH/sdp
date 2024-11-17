<?php
require_once 'Models/CashDonation.php';
require_once 'Views/CashDonationView.php';

class CashDonationController
{
    private $cashDonationModel;

    public function __construct($cashDonationModel)
    {
        $this->cashDonationModel = $cashDonationModel;
    }

    // Display all cash donations
    public function showAll()
    {
        $donations = $this->cashDonationModel->getAllDonations(); // Fetch all cash donations
        $view = new CashDonationView();
        echo $view->renderDonationsTable($donations);
    }

    // Add a new cash donation
    public function addDonation()
    {
        include 'views/AddCashDonationView.php'; // Render add form
    }

    // Save a new cash donation
    public function save($data)
    {
        $this->cashDonationModel->addCashDonation(
            $data['donationID'],
            $data['amount']
        );
        header('Location: index.php?action=showAllCashDonations');
    }

    // Edit a cash donation
    public function edit($id)
    {
        $donation = $this->cashDonationModel->getCashDonation($id);
        if ($donation) {
            include 'views/EditCashDonationView.php'; // Pass $donation to the form
        } else {
            echo "Donation not found.";
        }
    }

    // Update an existing cash donation
    public function update($id, $data)
    {
        $this->cashDonationModel->updateCashDonation($id, [
            'Amount' => $data['amount']
        ]);
        header('Location: index.php?action=showAllCashDonations');
    }

    // Delete a cash donation
    public function delete($id)
    {
        $this->cashDonationModel->deleteCashDonation($id);
        header('Location: index.php?action=showAllCashDonations');
    }
}
