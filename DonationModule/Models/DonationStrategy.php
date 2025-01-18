<?php

namespace DonationModule\Models;
interface DonationStrategy
{
    public function processDonation($id, $quantity);

}