<?php

namespace Models\Command;
use Models\Donation;
require_once './Models/Donation.php';
class DonationCart
{
    private $donations = [];
    private $totalCartAmount;

    public function __construct(){}
    public function addDonation(Donation $donation)
    {
        // Ensure donations array exists
        if (!isset($this->donations)) {
            $this->donations = [];
        }

        $this->donations[] = [
            'donationType' => $donation->getType(),
            'quantity' => $donation->getQuantity(),
            'pricePerUnit' => $donation->getAmount(),
            'totalAmount' => $donation->getAmount() *$donation->getQuantity()
        ];
    }

    public function removeDonation($donation) {
        $key = array_search($donation, $this->donations);
        if ($key !== false) {
            unset($this->donations[$key]);
           // return "Removed donation: " . json_encode($donation) ;
        } else {
           // return "Donation not found: " . json_encode($donation) ;
        }
    }
    public function getDonations()
    {
        return $this->donations;
    }





}