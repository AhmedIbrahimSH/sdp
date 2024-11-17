<?php

require_once 'Person.php';
require_once 'Needs/NeedFactory.php';
// Beneficiary Class
class Beneficiary extends Person
{
    private $income;
    private $bloodType;
    private $hasChronicDisease;
    private $hasDisability;
    private $isHomeless;
    private $db;
    private $PersonID = Null;
    private $needs = [];

    // Constructor to initialize the database connection
    public function __construct($db, $beneficiaryId)
    {
        $this->db = $db;
        // Get the beneficiary details from the database
        $query = "SELECT * FROM Person JOIN Beneficiary ON Person.PersonID = Beneficiary.PersonID WHERE Person.PersonID = :personID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':personID', $beneficiaryId, PDO::PARAM_INT);
        $stmt->execute();
        $beneficiary = $stmt->fetch(PDO::FETCH_OBJ);

        // Call the parent constructor to set the common properties
        parent::__construct($beneficiary->FirstName, $beneficiary->LastName, $beneficiary->MiddleName, $beneficiary->Nationality, $beneficiary->Gender, $beneficiary->PersonPhone, $beneficiary->AddressID);

        // Set the Beneficiary specific properties
        $this->income = $beneficiary->income;
        $this->bloodType = $beneficiary->blood_type;
        $this->hasChronicDisease = $beneficiary->hasChronicDisease;
        $this->hasDisability = $beneficiary->hasDisability;
        $this->isHomeless = $beneficiary->isHomeless;
        $this->PersonID = $beneficiary->PersonID;
    }


    public function RequestNeed($need, $amount)
    {
        // Check for duplicate need type
        foreach ($this->needs as $existingNeed) {
            if (get_class($existingNeed) === $need) {
                return "Error: Duplicate need type";
            }
        }

        $need_obj = NeedFactory::createNeed($need);
        if ($need_obj) {
            if ($need_obj->Register_Need_Template($this, $this->PersonID, $amount)) {
                $this->needs[] = $need_obj;
                return true;
            }
            return false;
        }
        return false;
    }


    public function RemoveNeed($need)  // update = remove or request/add
    {
        $index = array_search($need, $this->needs);
        if ($index !== false) {
            unset($this->needs[$index]);
            return true;
        }
        return false;
    }

    public function SupportNeed($need, $amount)
    {
        $need->Support_Need_Template($this, $amount);
    }












    // ------------------- Getter and Setter -------------------



    // income getter and setter
    public function getIncome()
    {
        return $this->income;
    }

    public function setIncome($income)
    {
        $this->income = $income;
    }

    // hasChronicDisease getter
    public function hasChronicDisease()
    {
        return $this->hasChronicDisease;
    }

    public function hasDisability()
    {
        return $this->hasDisability;
    }

    public function isHomeless()
    {
        return $this->isHomeless;
    }


    public function getNeeds()
    {
        return $this->needs;
    }
    public function getBloodType()
    {
        return $this->bloodType;
    }

    public function getPersonID()
    {
        return $this->PersonID;
    }
}
