<?php

//use models\Database;

require_once 'Models\Database.php';

abstract class NeedTemplateMethod
{
    protected $incomeThreshold = 3000;
    protected $dbConnection;
    protected $allocationID;
    protected $BeneficiaryID;
    protected $Amount;
    protected $isAllocated;
    protected $isAccepted;
    protected $RegisterDate;
    protected $purpose;


    // Constructor with default values to be able to use empty objects
    public function __construct(
        $allocationID = null,
        $BeneficiaryID = null,
        $Amount = null,
        $isAllocated = null,
        $isAccepted = null,
        $RegisterDate = null,
        $purpose = null,
    ) {
        // Initialize the database connection here
        $this->dbConnection = Database::$instance->getConnection();

        // Optionally initialize properties if values are provided
        if ($allocationID !== null) {
            $this->allocationID = $allocationID;
        }
        if ($BeneficiaryID !== null) {
            $this->BeneficiaryID = $BeneficiaryID;
        }
        if ($Amount !== null) {
            $this->Amount = $Amount;
        }
        if ($isAllocated !== null) {
            $this->isAllocated = $isAllocated;
        }
        if ($isAccepted !== null) {
            $this->isAccepted = $isAccepted;
        }
        if ($RegisterDate !== null) {
            $this->RegisterDate = $RegisterDate;
        }
        if ($purpose !== null) {
            $this->purpose = $purpose;
        }
    }

    // The template method, defines the steps in the need registration process
    public function Register_Need_Template($Beneficiary, $BeneficiaryID, $amount)
    {
        $Accepted = true;
        // Step 1: Check eligibility (subclass defines this)
        if (!$this->checkEligibility($Beneficiary)) {
            $Accepted = false;
        }
        // I will always register the need, even if the beneficiary is not eligible (registered with rejection)

        // Step 2: Register need (subclass defines this)
        $this->register($BeneficiaryID, $amount, $Accepted);

        return true;
    }

    public function Support_Need_Template($beneficiary, $table, $BeneficiaryID)
    {

        // Step 1: Check eligibility again (subclass defines this)
        if (!$this->checkEligibility($beneficiary)) {
            return "e1";
        }

        // step 2: Check if we have recources
        if (!$this->checkResources($table, $BeneficiaryID)) {
            return "e2";
        }

        // Step 3: Allocate resources (subclass defines this)
        if (!$this->allocateResources($table, $BeneficiaryID)) {
            return "e3";
        }

        return "success";
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



    // ------------------- Getters ------------------

    // Change visibility of getters to public
    public function getAllocationID()
    {
        return $this->allocationID;
    }
    public function getBeneficiaryID()
    {
        return $this->BeneficiaryID;
    }
    public function getAmount()
    {
        return $this->Amount;
    }
    public function isAllocated()
    {
        return $this->isAllocated;
    }
    public function isAccepted()
    {
        return $this->isAccepted;
    }
    public function getRegisterDate()
    {
        return $this->RegisterDate;
    }
    public function getPurpose()
    {
        return $this->purpose;
    }
}
