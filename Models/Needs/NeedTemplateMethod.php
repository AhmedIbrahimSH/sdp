<?php


// --increase the spendings in the storage
// UPDATE Charity_Storage SET Spendings = Spendings + 1000.00 WHERE type = 'Cash';
// -- increase the affected people
// UPDATE Charity_Storage SET AffectedPeople = AffectedPeople + 1 WHERE type = 'Cash';

require_once 'Models\Database.php';
// Abstract Base Class: NeedRegistration
abstract class NeedTemplateMethod
{
    protected $incomeThreshold = 3000;
    protected $dbConnection;

    public function __construct()
    {
        // Initialize the database connection here
        $this->dbConnection = Database::$instance->getConnection();
    }

    // The template method, defines the steps in the need registration process
    public function Register_Need_Template($Beneficiary, $BeneficiaryID, $amount)
    {
        $Accepted = true;
        // Step 1: Check eligibility (subclass defines this)
        if (!$this->checkEligibility($Beneficiary)) {
            $Accepted = false;
        }

        // Step 2: Register need (subclass defines this)
        $this->register($BeneficiaryID, $amount, $Accepted);

        // Send notification to Donators!
        // $this->notifyDonators($BeneficiaryID);
        return true;
    }

    public function Support_Need_Template($beneficiary, $table, $BeneficiaryID)
    {

        // Step 1: Check eligibility again (subclass defines this)
        if (!$this->checkEligibility($beneficiary)) {
            echo "Not eligible for " . $this->getNeedType() . " need.\n";
            return;
        }

        // step 2: Check if we have recources
        if (!$this->checkResources($table, $BeneficiaryID)) {
            echo "Not enough resources for " . $this->getNeedType() . " need.\n";
            return;
        }

        // Step 2: Allocate resources (subclass defines this)
        $this->allocateResources($table, $BeneficiaryID);

        // Step 3: Log additional actions (optional)
        //$this->logNeedRegistration($beneficiary);
    }

    // Abstract method: Subclasses define eligibility check
    protected abstract function checkEligibility($beneficiary);

    // Abstract method: Subclasses define resource allocation
    protected abstract function allocateResources($table, $beneficiaryID);

    // Abstract method: Subclasses define the actual registration
    protected abstract function register($beneficiaryID, $amount, $Accepted);

    // Abstract method: Subclasses define check their resources!
    protected abstract function checkResources($table, $BeneficiaryID);



    // A hook to get the need type (food, medical, etc.)
    protected abstract function getNeedType();

    public function getIncomeThreshold()
    {
        return $this->incomeThreshold;
    }
}
