<?php

namespace Models\Strategy;

class Payment
{

    private $paymentMethod;
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // Model is responsible for database interactions
    }

    public function setPaymentMethod(IPay $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function pay($amount)
    {
        return $this->paymentMethod->processPayment($amount);
    }


}