<?php

namespace Models\Strategy;

class CreditCardPayment implements IPay
{
    private $cardNumber;
    private $cardHolderName;
    private $expiryDate;
    private $cvv;
    private $amount;

    private $model;

    public function __construct($model)
    {
        $this->model = $model; // Model is responsible for database interactions
    }

//    public function __construct($cardNumber, $cardHolderName, $expiryDate, $cvv, $amount)
//    {
//        $this->cardNumber = $cardNumber;
//        $this->cardHolderName = $cardHolderName;
//        $this->expiryDate = $expiryDate;
//        $this->cvv = $cvv;
//        $this->amount = $amount;
//    }


    public function processPayment()
    {
        // Logic for processing credit card payment
        //echo "Processing credit card payment of {$this->amount} for card ending in " . substr($this->cardNumber, -4) . ".";
    }

    public function validatePaymentDetails()
    {
        // Validate credit card details
        if (empty($this->cardNumber) || empty($this->cardHolderName) || empty($this->expiryDate) || empty($this->cvv) || $this->amount <= 0) {
            throw new Exception("Invalid credit card details or amount.");
        }
        //echo "Credit card payment details validated.";
    }

    public function generateReceipt()
    {
        // Generate receipt for the credit card payment
        return "Receipt: Credit card payment of {$this->amount} for card ending in " . substr($this->cardNumber, -4) . ".";
    }
}