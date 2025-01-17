<?php

namespace Models\Command;
use Models\Donation;
class DonationCart
{
    private $donations = [];
    private $totalCartAmount;

    public function __construct(){}
    public function addDonation($donationType,Donation $donation) {

        //return "Added donation: " . json_encode($donation) ;
    }

    public function removeDonation($donation) {
        $key = array_search($donation, $this->donations);
        if ($key !== false) {
            unset($this->donations[$key]);
            return "Removed donation: " . json_encode($donation) ;
        } else {
            return "Donation not found: " . json_encode($donation) ;
        }
    }
    public function getDonations()
    {
        return $this->donations;
    }





}