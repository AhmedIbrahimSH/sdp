<?php

namespace Controllers;
require_once './Models/Command/IDonationCommand.php';
require_once './Models/Command/DonationCartHandleCommand.php';
require_once './Models/Command/DonationCartManager.php';
require_once './Models/Command/DonationCart.php';




use Models\Command\DonationCart;
use Models\Command\DonationCartHandleCommand;
use Models\Command\DonationCartManager;
use Models\Command\IDonationCommand;

use Models\Donation;
use Models\DonationStrategy;


class DonationCartController
{
    private  DonationCart $donationCart;
    private  $donationCartManager;
    private  $command;
    private   $donation;




    public function __construct(Donation $donation)
    {
        //session_start(); // Start session to access stored cart

//        // Retrieve existing cart from session or create a new one
//        if (isset($_SESSION['donation_cart'])) {
//            $this->donationCart = unserialize($_SESSION['donation_cart']); // Unserialize the object
//        } else {
//            $this->donationCart = new DonationCart();
//            $_SESSION['donation_cart'] = serialize($this->donationCart); // Store as serialized object
//        }

        $this->donation=$donation;
        $this->donationCartManager = new DonationCartManager();
        $this->donationCart = new DonationCart();

        $this->command = new DonationCartHandleCommand($this->donationCart,$this->donation);
    }
//    public function setDonationfromView($donation)
//    {
//        $this->donation=$donation;
//
//    }
    public function setCommandfromView()
    {
        $this->donationCartManager->setCommand($this->command);

    }
    public function redoclicked()
    {
        $this->donationCartManager->redoButtonPressed();
    }
    public function undoclicked()
    {
        $this->donationCartManager->undoButtonPressed();

    }

    public function AddDonationToCart($donation)
    {
//        //$this->donationCart->addDonation($this->donation);
//        foreach ($donations as $donation) {
//            $this->donationCart->addDonation(
//                $donation['donationType'],
//                $donation['quantity'],
//                $donation['pricePerUnit']
//            );
//        }
        //$_SESSION['donation_cart'] = serialize($this->donationCart);
        $this->donationCart->addDonation($donation);
    }
    public function getCartItems()
    {
        // Retrieve stored cart items
        if (isset($_SESSION['donation_cart'])) {
            return unserialize($_SESSION['donation_cart']);
        }
        return [];
        //return isset($_SESSION['donation_cart']) ? $_SESSION['donation_cart']->getItems() : [];
    }
}