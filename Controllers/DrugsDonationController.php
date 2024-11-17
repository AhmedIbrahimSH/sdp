<?php
require_once 'Models/DrugsDonation.php';
require_once 'Views/DrugsDonationView.php';
class DrugsDonationController
{
    private $drugsDonationModel;

    public function __construct($drugsDonationModel)
    {
        $this->drugsDonationModel = $drugsDonationModel;
    }

    public function showAll()
    {
        $donations = $this->drugsDonationModel->getAllDonations();
        $view = new DrugsDonationView();
        echo $view->renderDonationsTable($donations);
    }

    public function add()
    {
        include 'views/AddDrugsDonationView.php';
    }

    public function save($data)
    {
        $this->drugsDonationModel->addDonation(
            $data['donationDate'],
            $data['paymentMethod'],
            $data['totalAmount'],
            $data['personID']
        );
        header('Location: index.php?action=showAllDrugsDonations');
    }

    public function edit($id)
    {
        $donation = $this->drugsDonationModel->getDonationById($id);
        if ($donation) {
            include 'views/EditDrugsDonationView.php';
        } else {
            echo "Donation not found.";
        }
    }

    public function update($id, $data)
    {
        $this->drugsDonationModel->updateDonation($id, [
            'DonationDate' => $data['donationDate'],
            'PaymentMethod' => $data['paymentMethod'],
            'TotalAmount' => $data['totalAmount'],
            'PersonID' => $data['personID']
        ]);
        header('Location: index.php?action=showAllDrugsDonations');
    }

    public function delete($id)
    {
        $this->drugsDonationModel->deleteDonation($id);
        header('Location: index.php?action=showAllDrugsDonations');
    }
}
