<?php

namespace DonationModule\Models\Strategy;
interface IPay
{
    public function processPayment();

    public function validatePaymentDetails();

    public function generateReceipt();
}