<?php

namespace Models\Command;
use Models\Donation;
class DonationCart
{
    private $donations = [];
    private $totalCartAmount;

    public function __construct(){}
    public function addDonation($donationType, $quantity, $pricePerUnit)
    {
        // Ensure donations array exists
        if (!isset($this->donations)) {
            $this->donations = [];
        }

        // Store donation as an associative array
        $this->donations[] = [
            'donationType' => $donationType,
            'quantity' => $quantity,
            'pricePerUnit' => $pricePerUnit,
            'totalAmount' => $pricePerUnit * $quantity
        ];
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