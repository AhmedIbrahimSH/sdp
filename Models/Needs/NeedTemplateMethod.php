<?php

require_once 'Database.php';
// Abstract Base Class: NeedRegistration
abstract class NeedTemplateMethod
{
    protected $incomeThreshold = 1000;
    protected $dbConnection = Database::$instance->getConnection();


    // The template method, defines the steps in the need registration process
    public function Register_Need_Template($Beneficiary, $BeneficiaryID, $amount)
    {
        // Step 1: Check eligibility (subclass defines this)
        if (!$this->checkEligibility($Beneficiary)) {
            echo "Not eligible for " . $this->getNeedType() . " need.\n";
            return;
        }

        // Step 2: Register need (subclass defines this)
        $this->register($BeneficiaryID, $amount);


        // Step 3: Log registration or additional actions (optional)
        $this->logNeedRegistration($BeneficiaryID); // show its row in the table

        // Send notification to Donators!
        // $this->notifyDonators($BeneficiaryID);
        return true;
    }

    public function Support_Need_Template($BeneficiaryID, $amount)
    {

        // Step 1: Check eligibility again (subclass defines this)
        if (!$this->checkEligibility($BeneficiaryID)) {
            echo "Not eligible for " . $this->getNeedType() . " need.\n";
            return;
        }
        echo "Eligible for " . $this->getNeedType() . " need ✅ \n";

        // step 2: Check if we have recources
        if (!$this->checkResources($amount)) {
            echo "Not enough resources for " . $this->getNeedType() . " need.\n";
            return;
        }

        // Step 2: Allocate resources (subclass defines this)
        $this->allocateResources($BeneficiaryID);

        // Step 3: Log additional actions (optional)
        //$this->logNeedRegistration($beneficiary);
    }

    // Abstract method: Subclasses define eligibility check
    protected abstract function checkEligibility($beneficiary);

    // Abstract method: Subclasses define resource allocation
    protected abstract function allocateResources($beneficiary);

    // Abstract method: Subclasses define the actual registration
    protected abstract function register($beneficiaryID, $amount);

    // Abstract method: Subclasses define check their resources!
    protected abstract function checkResources($amount);

    // Optional hook for logging the need registration (could be overridden)
    protected function logNeedRegistration($beneficiary)
    {
        echo "Need registered for Beneficiary : " . $beneficiary->getName() . "\n";
    }

    // A hook to get the need type (food, medical, etc.)
    protected abstract function getNeedType();
}
