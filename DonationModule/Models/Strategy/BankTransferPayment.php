<?php

namespace DonationModule\Models\Strategy;

use Models\Strategy\Exception;

require_once("DonationModule/Models/Database.php");
require_once 'IPay.php';

class BankTransferPayment implements IPay
{
    private $model;
    private $bankAccount;
    private $transferAmount;

    public function __construct($model)
    {
        $this->model = $model; // Model is responsible for database interactions
    }


//    public function __construct($bankAccount, $transferAmount)
//    {
//        $this->bankAccount = $bankAccount;
//        $this->transferAmount = $transferAmount;
//    }

    public function processPayment()
    {
        // Logic for processing bank transfer payment
        echo "Processing bank transfer payment of {$this->transferAmount} to account {$this->bankAccount}.";
    }

    public function validatePaymentDetails()
    {
        // Validate bank account details
        if (empty($this->bankAccount) || $this->transferAmount <= 0) {
            throw new Exception("Invalid bank account or transfer amount.");
        }
        echo "Bank transfer payment details validated.";
    }

    public function generateReceipt()
    {
        // Generate receipt for the bank transfer payment
        return "Receipt: Bank transfer of {$this->transferAmount} to account {$this->bankAccount}.";
    }
}