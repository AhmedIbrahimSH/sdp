<?php

namespace Models;
interface DonationStrategy
{
    public function processDonation($id, $quantity);

}