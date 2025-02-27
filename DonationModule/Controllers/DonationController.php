<?php

namespace Controllers;

use Exception;
use Models\CashDonation;
use Models\ClothesDonation;
use Models\DrugsDonation;
use Models\FoodDonation;
use Views\AddCashDonationView;
use Views\AddClothesDonationView;
use Views\AddDrugsDonationView;
use Views\AddFoodDonationView;
use Views\DonationsView;
use Views\DonationTypesView;
use Views\PaymentStrategiesView;

require_once 'Models/Donation.php';

require_once 'Views/DonationsView.php';
require_once 'Views/DonationTypesView.php';
require_once 'Views/AddCashDonationView.php';
require_once 'Views/AddFoodDonationView.php';
require_once 'Views/AddDrugsDonationView.php';
require_once 'Views/AddClothesDonationView.php';


require_once 'Models/CashDonation.php';
require_once 'Models/FoodDonation.php';
require_once 'Models/DrugsDonation.php';
require_once 'Models/ClothesDonation.php';

require_once 'Views/PaymentStrategiesView.php';


class DonationController
{
    private $donationModel;
    private $strategy;

    /**
     * @return mixed
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    // Constructor to initialize the model
    public function __construct($donationModel)
    {
        $this->donationModel = $donationModel;
        // Retrieve strategy from session if it exists
        //        if (isset($_SESSION['strategy'])) {
        //            $this->strategy = unserialize($_SESSION['strategy']); // Unserialize the stored strategy
        //            $this->donationModel->setStrategy($this->strategy);
        //        }


    }

    //Navigate to the Donation types screen
    public function DonationTypes()
    {
        $view = new DonationTypesView();
        echo $view->renderDonationTypeSelection();
    }

    public function ProcessStrategy($type)
    {
        switch ($type) {
            case 'cashDonation':
                $strategy = new CashDonation($this->donationModel);
                $view = new AddCashDonationView();
                $view->render();
                break;

            case 'foodDonation':
                $strategy = new FoodDonation($this->donationModel);
                $view = new AddFoodDonationView();
                $view->render($strategy->getPREDEFINEDAMOUNTPERITEM());
                break;

            case 'drugsDonation':
                $strategy = new DrugsDonation($this->donationModel);
                $view = new AddDrugsDonationView();
                $view->render($strategy->getPREDEFINEDAMOUNTPERITEM());
                break;

            case 'clothesDonation':
                $strategy = new ClothesDonation($this->donationModel);
                $view = new AddClothesDonationView();
                $view->render($strategy->getPREDEFINEDAMOUNTPERITEM());
                break;

            default:
                throw new Exception("Invalid donation type");
        }
        $_SESSION['strategy'] = serialize($strategy);
        $this->donationModel->setstrategy($strategy);
    }

    public function SaveData($PassedData)
    {
        // Retrieve the strategy from the session if not already set
        if (!$this->strategy && isset($_SESSION['strategy'])) {
            $this->strategy = unserialize($_SESSION['strategy']); // Unserialize to retrieve the object
            $this->donationModel->setstrategy($this->strategy);
        }

        if (!$this->strategy) {
            throw new Exception("Strategy not set.");
        }

        $data = isset($PassedData['Data']) ? (int)$PassedData['Data'] : 0;
        $this->strategy->setData($data);

        $donationDetails = $this->strategy->getDonationDetails();
        $view = new PaymentStrategiesView();
        $view->render($donationDetails['quantity'], $donationDetails['amount'], $donationDetails['totalAmount']);
    }


    // Show all donations
    public function showAll()
    {
        $donations = $this->donationModel->getAllDonations(); // Fetch all donations
        $view = new DonationsView(); // Initialize the view class
        echo $view->renderDonationsTable($donations); // Render donations table
    }


    //    Public function PerformDonation($strategy)
    //    {
    //        $this->donationModel->SetStrategy($strategy);
    //
    //
    //    }

    // Add a new donation (renders the add form)


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
