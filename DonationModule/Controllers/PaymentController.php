<?php


namespace Controllers;

use Models\Strategy\BankTransferPayment;
use Models\Strategy\CreditCardPayment;
use Models\Strategy\PayPalPayment;
use Views\BankTransferPaymentView;
use Views\CreditCardPaymentView;
use Views\PaymentStrategiesView;
use Views\PayPalPaymentView;

require_once 'Models/Donation.php';
require_once 'Models/Strategy/Payment.php';
require_once 'Models/Strategy/BankTransferPayment.php';
require_once 'Models/Strategy/CreditCardPayment.php';
require_once 'Models/Strategy/PayPalPayment.php';

require_once 'Views/CreditCardPaymentView.php';
require_once 'Views/PayPalPaymentView.php';
require_once 'Views/BankTransferPaymentView.php';


class PaymentController
{
    private $paymentModel;


    public function __construct($paymentModel)
    {
        $this->paymentModel = $paymentModel;
    }

    public function ProcessStrategy($paymentType)
    {
        switch ($paymentType) {
            case 'creditCard':
                // Instantiate the CreditCardPayment view
                $strategy = new CreditCardPayment($this->paymentModel);
                $view = new CreditCardPaymentView();
                $view->render(); // Render the form for Credit Card Payment
                break;

            case 'paypal':
                // Instantiate the PayPalPayment view
                $strategy = new PayPalPayment($this->paymentModel);
                $view = new PayPalPaymentView();
                $view->render(); // Render the form for PayPal Payment
                break;

            case 'banktransfer':
                // Instantiate the BankTransferPayment view
                $strategy = new BankTransferPayment($this->paymentModel);
                $view = new BankTransferPaymentView();
                $view->render(); // Render the form for Bank Transfer Payment
                break;

            default:
                throw new Exception("Invalid payment type selected");
        }
        $_SESSION['Paymentmethod'] = serialize($strategy);
        $this->paymentModel->setPaymentMethod($strategy);
    }

    public function ShowAll()
    {

        $view = new PaymentStrategiesView();
        $view->render();
    }
}