<?php
require_once 'Person.php';

class BeneficiaryAdmin extends Person
{
    protected $email;
    protected $username;
    protected $password;
    //protected $Assigned_Location;
    protected $beneficiaries = []; // To store registered beneficiaries

    // public function __construct($name, $mobile, $address, $blood_type, $email, $username, $password)
    // {
    //     $this->email = $email;
    //     $this->username = $username;
    //     $this->password = $password;
    //     // $this->Assigned_Location = $Assigned_Location;


    //     parent::__construct($id, $name, $mobile, $address, $blood_type);
    // }
    public function __construct() {}

    public function CreateBeneficiary($db, $data)
    {
        try {
            // Prepare SQL statement
            $query = "INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
                      VALUES (:firstName, :lastName, :middleName, :nationality, :gender, :phone, :addressID)";

            $stmt = $db->prepare($query);

            // Bind parameters
            $stmt->bindParam(':firstName', $data['firstName']);
            $stmt->bindParam(':lastName', $data['lastName']);
            $stmt->bindParam(':middleName', $data['middleName']);
            $stmt->bindParam(':nationality', $data['nationality']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':addressID', $data['addressID']);

            // Execute the query to insert into Person table
            if ($stmt->execute()) {
                // Get the last inserted PersonID
                $personID = $db->lastInsertId();

                // Now insert into the Beneficiary table
                $query = "INSERT INTO Beneficiary (PersonID, income, blood_type, hasChronicDisease, hasDisability, isHomeless)
                          VALUES (:personID, :income, :bloodType, :hasChronicDisease, :hasDisability, :isHomeless)";

                $stmt = $db->prepare($query);

                // Bind parameters for the Beneficiary table
                $stmt->bindParam(':personID', $personID);
                $stmt->bindParam(':income', $data['income']);
                $stmt->bindParam(':bloodType', $data['bloodType']);

                $hasChronicDisease = isset($data['hasChronicDisease']) ? true : false;
                $hasDisability = isset($data['hasDisability']) ? true : false;
                $isHomeless = isset($data['isHomeless']) ? true : false;

                echo "hellooo>>> " . $hasChronicDisease . " " . $hasDisability . " " . $isHomeless . "<br>" . "<br>";

                $stmt->bindParam(':hasChronicDisease', $hasChronicDisease);
                $stmt->bindParam(':hasDisability', $hasDisability);
                $stmt->bindParam(':isHomeless', $isHomeless);

                // Execute the query to insert into Beneficiary table
                if ($stmt->execute()) {
                    return true;
                } else {
                    echo "Error: " . $stmt->errorInfo()[2];
                }
            }
            return false; // Failed to insert into the Person table
        } catch (PDOException $e) {
            return false; // Handle errors
        }
    }

    public function DeleteBeneficiary($db, $beneficiaryId)
    {
        try {
            // Begin transaction
            $db->beginTransaction();

            // Delete from beneficiary table
            $queryBeneficiary = "DELETE FROM beneficiary WHERE PersonID = :id";
            $stmtBeneficiary = $db->prepare($queryBeneficiary);
            $stmtBeneficiary->bindParam(':id', $beneficiaryId, PDO::PARAM_INT);
            $stmtBeneficiary->execute();

            // Delete from person table
            $queryPerson = "DELETE FROM person WHERE PersonID = :id";
            $stmtPerson = $db->prepare($queryPerson);
            $stmtPerson->bindParam(':id', $beneficiaryId, PDO::PARAM_INT);
            $stmtPerson->execute();

            // Commit transaction
            $db->commit();

            // Remove from beneficiaries array
            foreach ($this->beneficiaries as $key => $beneficiary) {
                if ($beneficiary->id == $beneficiaryId) {
                    unset($this->beneficiaries[$key]);
                    return true;
                }
            }
        } catch (PDOException $e) {
            // Rollback transaction if something failed
            $db->rollBack();
            return false;
        }
        return false;
    }

    public function updateBeneficiary($db, $beneficiaryId, $data)
    {
        // Update the person table
        $queryPerson = "UPDATE person SET 
                        FirstName = COALESCE(:firstName, FirstName),
                        MiddleName = COALESCE(:middleName, MiddleName),
                        LastName = COALESCE(:lastName, LastName),
                        PersonPhone = COALESCE(:phone, PersonPhone),
                        AddressID = COALESCE(:addressID, AddressID)
                        WHERE PersonID = :personID";
        $stmtPerson = $db->prepare($queryPerson);
        $stmtPerson->bindParam(':firstName', $data['FirstName'], PDO::PARAM_STR);
        $stmtPerson->bindParam(':middleName', $data['MiddleName'], PDO::PARAM_STR);
        $stmtPerson->bindParam(':lastName', $data['LastName'], PDO::PARAM_STR);
        $stmtPerson->bindParam(':phone', $data['PersonPhone'], PDO::PARAM_STR);
        $stmtPerson->bindParam(':addressID', $data['AddressID'], PDO::PARAM_INT);
        $stmtPerson->bindParam(':personID', $beneficiaryId, PDO::PARAM_INT);

        // Update the beneficiary table
        $queryBeneficiary = "UPDATE beneficiary SET 
                             income = COALESCE(:income, income),
                             hasChronicDisease = COALESCE(:hasChronicDisease, hasChronicDisease),
                             hasDisability = COALESCE(:hasDisability, hasDisability),
                             isHomeless = COALESCE(:isHomeless, isHomeless),
                             blood_type = COALESCE(:bloodType, blood_type)
                             WHERE PersonID = :personID";
        $stmtBeneficiary = $db->prepare($queryBeneficiary);
        $stmtBeneficiary->bindParam(':income', $data['income'], PDO::PARAM_STR);
        $stmtBeneficiary->bindParam(':hasChronicDisease', $data['hasChronicDisease'], PDO::PARAM_BOOL);
        $stmtBeneficiary->bindParam(':hasDisability', $data['hasDisability'], PDO::PARAM_BOOL);
        $stmtBeneficiary->bindParam(':isHomeless', $data['isHomeless'], PDO::PARAM_BOOL);
        $stmtBeneficiary->bindParam(':bloodType', $data['bloodType'], PDO::PARAM_STR);
        $stmtBeneficiary->bindParam(':personID', $beneficiaryId, PDO::PARAM_INT);

        // Execute both queries
        if ($stmtPerson->execute() && $stmtBeneficiary->execute()) {
            foreach ($this->beneficiaries as $beneficiary) {
                if ($beneficiary->id == $beneficiaryId) {
                    $beneficiary->FirstName = $data['FirstName'] ?? $beneficiary->FirstName;
                    $beneficiary->MiddleName = $data['MiddleName'] ?? $beneficiary->MiddleName;
                    $beneficiary->LastName = $data['LastName'] ?? $beneficiary->LastName;
                    $beneficiary->PersonPhone = $data['PersonPhone'] ?? $beneficiary->PersonPhone;
                    $beneficiary->AddressID = $data['AddressID'] ?? $beneficiary->AddressID;
                    $beneficiary->income = $data['income'] ?? $beneficiary->income;
                    $beneficiary->hasChronicDisease = $data['hasChronicDisease'] ?? $beneficiary->hasChronicDisease;
                    $beneficiary->hasDisability = $data['hasDisability'] ?? $beneficiary->hasDisability;
                    $beneficiary->isHomeless = $data['isHomeless'] ?? $beneficiary->isHomeless;
                    $beneficiary->blood_type = $data['bloodType'] ?? $beneficiary->blood_type;
                    return true;
                }
            }
        }
        return false;
    }


    public function getBeneficiaries($db)
    {
        $query = "SELECT p.PersonID, p.FirstName,p.MiddleName,p.LastName ,p.PersonPhone, p.AddressID,b.income, b.hasChronicDisease, b.hasDisability,b.isHomeless 
                  FROM person p 
                  JOIN beneficiary b ON p.PersonID = b.PersonID";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getBeneficiary($db, $BeneficiaryID) // gets a single beneficiary
    {
        return new Beneficiary($db, $BeneficiaryID);
    }

    function getAllocatedNeeds($db)
    {
        $tables = ['cashneedhistory', 'foodneedhistory', 'shelterneedhistory', 'drugneedhistory', 'medicalneedhistory', 'clothingneedhistory'];
        $allNeeds = [];

        foreach ($tables as $table) {
            $query = "SELECT * FROM $table WHERE Allocated = 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $needs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($needs as $need) {
                $need['table'] = ucfirst(str_replace('needhistory', '', $table)); // Add table name for context
                $allNeeds[] = $need;
            }
        }

        return $allNeeds;
    }

    function getCharityStorageData($db)
    {
        $query = "SELECT * FROM charity_storage";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
