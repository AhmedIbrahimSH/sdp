<?php

class BankTransferPayment implements IPay
{
    private $bankAccount;
    private $transferAmount;

    public function __construct($bankAccount, $transferAmount)
    {
        $this->bankAccount = $bankAccount;
        $this->transferAmount = $transferAmount;
    }

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