<?php
require_once 'Models/ClothesDonation.php';
require_once 'Views/ClothesDonationView.php';

class ClothesDonationController
{
    private $clothesDonationModel;

    public function __construct($clothesDonationModel)
    {
        $this->clothesDonationModel = $clothesDonationModel;
    }

    // Display all clothes donations
    public function showAll()
    {
        $donations = $this->clothesDonationModel->getAllDonations(); // Fetch all clothes donations
        $view = new ClothesDonationView();
        echo $view->renderDonationsTable($donations);
    }

    // Add a new clothes donation
    public function add()
    {
        include 'views/AddClothesDonationView.php'; // Render add form
    }

    // Save a new clothes donation
    public function save($data)
    {
        $this->clothesDonationModel->addClothesDonation(
            $data['donationID'],
            $data['quantity'],
            $data['amount']
        );
        header('Location: index.php?action=showAllClothesDonations');
    }

    // Edit a clothes donation
    public function edit($id)
    {
        $donation = $this->clothesDonationModel->getClothesDonation($id);
        if ($donation) {
            include 'views/EditClothesDonationView.php'; // Pass $donation to the form
        } else {
            echo "Donation not found.";
        }
    }

    // Update an existing clothes donation
    public function update($id, $data)
    {
        $this->clothesDonationModel->updateClothesDonation($id, [
            'Quantity' => $data['quantity'],
            'Amount' => $data['amount']
        ]);
        header('Location: index.php?action=showAllClothesDonations');
    }

    // Delete a clothes donation
    public function delete($id)
    {
        $this->clothesDonationModel->deleteClothesDonation($id);
        header('Location: index.php?action=showAllClothesDonations');
    }
}
