<?php

interface DonationStrategy
{
    public function processDonation($id,$amount,$quantity);
}