<?php

interface IPay
{
public function  processPayment();

public function  validatePaymentDetails();

public function generateReceipt();
}