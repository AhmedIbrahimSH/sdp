<?php

class PayPalPayment implements IPay
{
    private $email;
    private $amount;

    public function __construct($email, $amount)
    {
        $this->email = $email;
        $this->amount = $amount;
    }

    public function processPayment()
    {
        // Logic for processing PayPal payment
        echo "Processing PayPal payment of {$this->amount} to {$this->email}.";
    }

    public function validatePaymentDetails()
    {
        // Validate PayPal account details
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL) || $this->amount <= 0) {
            throw new Exception("Invalid PayPal email or amount.");
        }
        echo "PayPal payment details validated.";
    }

    public function generateReceipt()
    {
        // Generate receipt for the PayPal payment
        return "Receipt: PayPal payment of {$this->amount} to {$this->email}.";
    }
}