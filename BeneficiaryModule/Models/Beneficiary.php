<?php

require_once 'Person.php';
require_once 'Needs/NeedFactory.php';
// Beneficiary Class
class Beneficiary extends Person
{
    private $income;
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
        parent::__construct($beneficiary->FirstName, $beneficiary->LastName, $beneficiary->MiddleName, $beneficiary->Nationality, $beneficiary->Gender, $beneficiary->Phone, $beneficiary->AddressID);

        // Set the Beneficiary specific properties
        $this->income = $beneficiary->income;
        $this->hasChronicDisease = $beneficiary->hasChronicDisease;
        $this->hasDisability = $beneficiary->hasDisability;
        $this->isHomeless = $beneficiary->isHomeless;
        $this->PersonID = $beneficiary->PersonID;

        $needs = [];
        $needTables = ['cashneedhistory', 'foodneedhistory', 'clothingneedhistory', 'drugneedhistory', 'medicalneedhistory', 'shelterneedhistory']; // Add other need tables as necessary

        foreach ($needTables as $table) {
            $query = "SELECT *, '$table' as table_name FROM $table WHERE BeneficiaryID = :beneficiaryID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':beneficiaryID', $this->PersonID, PDO::PARAM_INT);
            $stmt->execute();
            $needs = array_merge($needs, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        $this->needs = $needs;
    }


    public function RequestNeed($need, $amount)
    {

        $need_obj = NeedFactory::createNeed($need);
        if ($need_obj) {
            if ($need_obj->Register_Need_Template($this, $this->PersonID, $amount)) {

                return true;
            }
            return false;
        }
        return false;
    }


    public function RemoveNeed($db, $needTable, $beneficiaryId, $needId)
    {
        $query = "DELETE FROM $needTable WHERE BeneficiaryID = :beneficiaryID AND AllocationID = :needID";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':beneficiaryID', $beneficiaryId, PDO::PARAM_INT);
        $stmt->bindParam(':needID', $needId, PDO::PARAM_INT);
        return $stmt->execute();
    }



    public function SupportNeed($table, $beneficiaryId)
    {
        $needType = explode('needhistory', $table)[0];
        $need_obj = NeedFactory::createNeed($needType);
        $need_obj->Support_Need_Template($this, $table, $beneficiaryId);
    }


    public function getNeeds()
    {
        return $this->needs;
    }

    // get need row by 











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




    public function getPersonID()
    {
        return $this->PersonID;
    }
}
