<?php

namespace DonationModule\Models\Command;
use DonationModule\Models\Donation;


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