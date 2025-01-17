<?php

namespace Models\Command;
use Models\Donation;
use MongoDB\Driver\Command;


class DonationCartHandleCommand implements IDonationCommand
{    private $cart;
    private $donation;

    public function __construct(DonationCart $cart, Donation $donation) {
        $this->cart = $cart;
        $this->donation = $donation;
    }
    public function execute() {
        $this->cart->addDonation($this->donation);

    }

    public function undo() {
        $this->cart->removeDonation($this->donation);
    }
}