<?php
require_once 'Models/Donation.php';
require_once 'Views/DonationsView.php';
require_once 'Views/DonationTypesView.php';
require_once 'Views/AddCashDonationView.php';
class DonationController
{
    private $donationModel;

    // Constructor to initialize the model
    public function __construct($donationModel)
    {
        $this->donationModel = $donationModel;
    }

    // Show all donations
    public function showAll()
    {
        $donations = $this->donationModel->getAllDonations(); // Fetch all donations
        $view = new DonationsView(); // Initialize the view class
        echo $view->renderDonationsTable($donations); // Render donations table
    }

    Public function ProcessStartegy($id,$data)
    {
        $this->donationModel->applyDonationStrategy($id,$data);
    }
    Public function PerformDonation($strategy)
    {
        $this->donationModel->SetStrategy($strategy);


    }

    // Add a new donation (renders the add form)
    public function DonationTypes()
    {    $view = new DonationTypesView();
        echo $view->renderDonationTypeSelection();
    }

    // Save a new donation
    public function saveDonation($data)
    {
        try {
            // Calculate totalAmount from quantity and amount
            $totalAmount = $data['quantity'] * $data['amount'];

            // Call addDonation with the calculated totalAmount
            $this->donationModel->addDonation(
                $data['donationType'],
                $data['donationDate'],
                $data['paymentMethod'],
                $totalAmount, // Use the calculated totalAmount
                $data['personID']
            );

            header('Location: index.php?action=showAllDonations');
        } catch (Exception $e) {
            echo "Error saving donation: " . $e->getMessage();
        }
    }

    // Edit an existing donation (renders the edit form)
    public function edit($id)
    {
        $donation = $this->donationModel->getDonationById($id); // Fetch donation by ID
        if ($donation) {
            include 'views/EditDonationView.php'; // Pass $donation to the edit form
        } else {
            echo "Donation not found.";
        }
    }

    // Update an existing donation
    public function update($id, $data)
    {
        try {
            $this->donationModel->updateDonation(
                $id,
                [
                    'DonationType' => $data['donationType'],
                    'DonationDate' => $data['donationDate'],
                    'PaymentMethod' => $data['paymentMethod'],
                    'TotalAmount' => $data['totalAmount'],
                    'PersonID' => $data['personID']
                ]
            );
            header('Location: index.php?action=showAllDonations');
        } catch (Exception $e) {
            echo "Error updating donation: " . $e->getMessage();
        }
    }

    // Delete a donation
    public function delete($id)
    {
        try {
            $this->donationModel->deleteDonation($id); // Delete donation by ID
            header('Location: index.php?action=showAllDonations');
        } catch (Exception $e) {
            echo "Error deleting donation: " . $e->getMessage();
        }
    }
}
