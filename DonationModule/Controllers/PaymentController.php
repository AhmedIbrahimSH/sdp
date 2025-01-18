<?php


namespace DonationModule\Controllers;

use Controllers\Exception;
use DonationModule\Models\Strategy\BankTransferPayment;
use DonationModule\Models\Strategy\CreditCardPayment;
use DonationModule\Models\Strategy\PayPalPayment;
use DonationModule\Views\BankTransferPaymentView;
use DonationModule\Views\CreditCardPaymentView;
use DonationModule\Views\PaymentStrategiesView;
use DonationModule\Views\PayPalPaymentView;

require_once 'DonationModule/Models/Donation.php';
require_once 'DonationModule/Models/Strategy/Payment.php';
require_once 'DonationModule/Models/Strategy/BankTransferPayment.php';
require_once 'DonationModule/Models/Strategy/CreditCardPayment.php';
require_once 'DonationModule/Models/Strategy/PayPalPayment.php';

require_once 'DonationModule/Views/CreditCardPaymentView.php';
require_once 'DonationModule/Views/PayPalPaymentView.php';
require_once 'DonationModule/Views/BankTransferPaymentView.php';


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
        //$view->render();
    }
}