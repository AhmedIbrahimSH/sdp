<?php
require_once 'Models/FoodDonation.php';
require_once 'Views/FoodDonationView.php';
require_once 'Models/Donation.php';
require_once 'Views/AddFoodDonationView.php';
require_once 'Controllers/DonationController.php';
class FoodDonationController
{
    private $foodDonationModel;


    public function __construct($foodDonationModel)
    {
        $this->foodDonationModel = $foodDonationModel;
    }

    public function add()
    {
        $view = new AddFoodDonationView();
        echo $view->render();
    }


    // Display all food donations
    public function showAll()
    {
        $donations = $this->foodDonationModel->getAllDonations(); // Fetch all food donations
        $view = new FoodDonationView();
        echo $view->renderDonationsTable($donations);
    }

    // Add a new food donation


    // Save a new food donation
    public function save($data)
    {
        $this->foodDonationModel->addFoodDonation(
            $data['donationID'],
            $data['quantity'],
            $data['amount']
        );


        header('Location: index.php?action=showAllFoodDonations');
    }

    // Edit a food donation
    public function edit($id)
    {
        $donation = $this->foodDonationModel->getFoodDonation($id);
        if ($donation) {
            include 'views/EditFoodDonationView.php'; // Pass $donation to the form
        } else {
            echo "Donation not found.";
        }
    }

    // Update an existing food donation
    public function update($id, $data)
    {
        $this->foodDonationModel->updateFoodDonation($id, [
            'Quantity' => $data['quantity'],
            'Amount' => $data['amount']
        ]);
        header('Location: index.php?action=showAllFoodDonations');
    }

    // Delete a food donation
    public function delete($id)
    {
        $this->foodDonationModel->deleteFoodDonation($id);
        header('Location: index.php?action=showAllFoodDonations');
    }
}
