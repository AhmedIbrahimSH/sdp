<?php

class Payment
{

    private  $paymentMethod;

    public function setPaymentMethod(IPay $paymentMethod){
        $this->paymentMethod = $paymentMethod;
    }

    public function pay($amount){
        return $this->paymentMethod->processPayment($amount);
    }


}