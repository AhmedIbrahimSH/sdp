<?php
require_once 'NeedTemplateMethod.php';

// Concrete class: FoodNeed
class FoodNeed extends NeedTemplateMethod
{

    public function __construct()
    {
        echo "Food need created \n";
    }
    function checkEligibility($beneficiary)
    {
        return $beneficiary->getIncome() < self::$incomeThreshold;
    }


    protected function register($beneficiaryID, $amount)
    {
        // for food need



    }

    protected function allocateResources($beneficiary)
    {
        // Example: Allocate food resources to the beneficiary
        echo "Allocating food resources for " . $beneficiary->getName() . "\n";
    }
    protected function checkResources($amount)
    {
        // Example: Check if there are enough food resources for the beneficiary
        echo "Checking food resources \n";
        return true; // Assuming resources are available
    }


    protected function getNeedType()
    {
        return "Food";
    }
}
