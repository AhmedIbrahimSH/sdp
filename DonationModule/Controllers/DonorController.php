<?php

namespace Controllers;

use Views\DonorsListView;
use Views\DonorViewUpdate;
use Exception;

require_once 'Models/Donor.php';
require_once 'Views/DonorsListView.php';
require_once 'Views/donorView.php';
require 'Views/UpdateDonorView.php';

class DonorController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function Show($id)
    {
        $donor = $this->model->getDonor($id);
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

    public function edit($id)
    {

        $donor = $this->model->getDonor($id);


        if (!$donor) {
            throw new Exception("Donor with ID $id not found.");
        }

        // Pass the donor to the update view
        $view = new DonorViewUpdate();
        $view->renderUpdateForm($donor);
    }

    // Update donor details
    public function update($id, $data)
    {
        try {
            $this->model->updateDonor($id, $data);
            header("Location: index.php?action=showAllDonors"); // Redirect to donor list
        } catch (Exception $e) {
            throw new Exception("Failed to update donor: " . $e->getMessage());
        }
    }


    public function saveDonor($data)
    {
        $this->model->addDonor($data);
        header('Location: index.php?action=showAllDonors'); // Redirect back to donor list
    }

    // Delete a donor
    public function delete($id)
    {
        $this->model->deleteDonor($id);
        header("Location: index.php?action=showAllDonors");
    }
}
