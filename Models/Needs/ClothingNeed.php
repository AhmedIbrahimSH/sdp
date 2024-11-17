<?php
require_once 'NeedTemplateMethod.php';

class ClothingNeed extends NeedTemplateMethod
{
    function checkEligibility($beneficiary)
    {
        return $beneficiary->getIncome() < self::$incomeThreshold;
    }

    protected function register($beneficiary)
    {
        // Register the clothing need for the beneficiary
        echo "Clothing need registered for " . $beneficiary->getName() . "\n";
    }

    protected function allocateResources($beneficiary)
    {
        // Example: Allocate clothing resources to the beneficiary
        echo "Allocating clothing resources for " . $beneficiary->getName() . "\n";
    }

    protected function checkResources($amount)
    {
        // Example: Check if there are enough clothing resources for the beneficiary
        echo "Checking clothing resources \n";
        return true; // Assuming resources are available
    }

    protected function getNeedType()
    {
        return "Clothing";
    }
}
