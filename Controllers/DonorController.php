<?php
require_once 'Models/Donor.php';
require_once 'Views/DonorsListView.php';
require_once 'Views/donorView.php';
class DonorController
{
    private $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function Show($id)
    {
        $donor=$this->model->getDonor($id);
        require 'Views/donorView.php';

    }
    public function ShowAll()
    {

        $donors = $this->model->getAllDonors();

        $view = new DonorsListView();

        $view->display($donors);
    }
    // Add a new donor
    public function add($data)
    {
        $this->model->addDonor($data);
        header("Location: index.php?action=showAllDonors");
    }

    // Update an existing donor
    public function update($id, $data)
    {
        $this->model->updateDonor($id, $data);
        header("Location: index.php?action=showDonor&id=" . $id);
    }

    public function saveDonor($data) {
        $db = Database::getInstance();
        $model = new Donor($db);
        $model->addDonor($data);
        header('Location: index.php?action=showAllDonors'); // Redirect back to donor list
    }

    // Delete a donor
    public function delete($id)
    {
        $this->model->deleteDonor($id);
        header("Location: index.php?action=showAllDonors");
    }
}