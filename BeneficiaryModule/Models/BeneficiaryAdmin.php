<?php
require_once 'Person.php';
require_once 'Beneficiary_Iterators\Beneficiary_Collection_Interface.php';
require_once 'Beneficiary_Iterators\Income_Based_Iterator.php';
class BeneficiaryAdmin extends Person implements BeneficiariesCollectionInterface
{
    protected $email;
    protected $username;
    protected $password;
    //protected $Assigned_Location;
    protected $beneficiaries = []; // To store registered beneficiaries

    public function __construct($db)
    {
        $this->initBeneficiaries($db);
    }

    public function getIterator(): BeneficiaryIterator
    {
        return new IncomeBasedIterator($this->beneficiaries);
    }

    public function initBeneficiaries($db)
    {
        $query = "SELECT p.PersonID 
              FROM person p 
              JOIN beneficiary b ON p.PersonID = b.PersonID";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create an array of Beneficiary objects
        $beneficiaries = [];
        foreach ($result as $row) {
            $beneficiary = new Beneficiary($db, $row['PersonID']);
            $beneficiaries[] = $beneficiary;
        }
        $this->beneficiaries = $beneficiaries;
    }

    public function CreateBeneficiary($db, $data)
    {
        try {
            // Prepare SQL statement
            $query = "INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
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
                $query = "INSERT INTO Beneficiary (PersonID, income,hasChronicDisease, hasDisability, isHomeless)
                          VALUES (:personID, :income,  :hasChronicDisease, :hasDisability, :isHomeless)";

                $stmt = $db->prepare($query);

                // Bind parameters for the Beneficiary table
                $stmt->bindParam(':personID', $personID);
                $stmt->bindParam(':income', $data['income']);

                $hasChronicDisease = isset($data['hasChronicDisease']) ? true : false;
                $hasDisability = isset($data['hasDisability']) ? true : false;
                $isHomeless = isset($data['isHomeless']) ? true : false;
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
                if ($beneficiary->getPersonID() == $beneficiaryId) {
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
        try {
            // Begin transaction
            $db->beginTransaction();

            // Update the person table
            $queryPerson = "UPDATE person SET 
                        FirstName = COALESCE(:firstName, FirstName),
                        MiddleName = COALESCE(:middleName, MiddleName),
                        LastName = COALESCE(:lastName, LastName),
                        Phone = COALESCE(:phone, Phone),
                        AddressID = COALESCE(:addressID, AddressID)
                        WHERE PersonID = :personID";

            $stmtPerson = $db->prepare($queryPerson);

            $stmtPerson->bindValue(':firstName', $data['firstName'] ?? null, PDO::PARAM_STR);
            $stmtPerson->bindValue(':middleName', $data['middleName'] ?? null, PDO::PARAM_STR);
            $stmtPerson->bindValue(':lastName', $data['lastName'] ?? null, PDO::PARAM_STR);
            $stmtPerson->bindValue(':phone', $data['phone'] ?? null, PDO::PARAM_STR);
            $stmtPerson->bindValue(':addressID', $data['addressID'] ?? null, PDO::PARAM_INT);
            $stmtPerson->bindValue(':personID', $beneficiaryId, PDO::PARAM_INT);

            // Execute the person update query
            if (!$stmtPerson->execute()) {
                throw new Exception("Failed to update person: " . implode(", ", $stmtPerson->errorInfo()));
            }

            // Update the beneficiary table
            $queryBeneficiary = "UPDATE beneficiary SET 
                             income = COALESCE(:income, income),
                             hasChronicDisease = COALESCE(:hasChronicDisease, hasChronicDisease),
                             hasDisability = COALESCE(:hasDisability, hasDisability),
                             isHomeless = COALESCE(:isHomeless, isHomeless)
                             WHERE PersonID = :personID";

            $stmtBeneficiary = $db->prepare($queryBeneficiary);
            $stmtBeneficiary->bindValue(':income', $data['income'] ?? null, PDO::PARAM_STR);
            $stmtBeneficiary->bindValue(':hasChronicDisease', $data['hasChronicDisease'] ?? null, PDO::PARAM_BOOL);
            $stmtBeneficiary->bindValue(':hasDisability', $data['hasDisability'] ?? null, PDO::PARAM_BOOL);
            $stmtBeneficiary->bindValue(':isHomeless', $data['isHomeless'] ?? null, PDO::PARAM_BOOL);
            $stmtBeneficiary->bindValue(':personID', $beneficiaryId, PDO::PARAM_INT);

            // Execute the beneficiary update query
            if (!$stmtBeneficiary->execute()) {
                throw new Exception("Failed to update beneficiary: " . implode(", ", $stmtBeneficiary->errorInfo()));
            }

            // Commit transaction
            $db->commit();

            // Update the beneficiary object in memory
            foreach ($this->beneficiaries as $beneficiary) {
                if ($beneficiary->getPersonID() == $beneficiaryId) {
                    $beneficiary->FirstName = $data['firstName'] ?? $beneficiary->FirstName;
                    $beneficiary->MiddleName = $data['middleName'] ?? $beneficiary->MiddleName;
                    $beneficiary->LastName = $data['lastName'] ?? $beneficiary->LastName;
                    $beneficiary->Phone = $data['phone'] ?? $beneficiary->Phone;
                    $beneficiary->AddressID = $data['addressID'] ?? $beneficiary->AddressID;
                    $beneficiary->income = $data['income'] ?? $beneficiary->income;
                    $beneficiary->hasChronicDisease = $data['hasChronicDisease'] ?? $beneficiary->hasChronicDisease;
                    $beneficiary->hasDisability = $data['hasDisability'] ?? $beneficiary->hasDisability;
                    $beneficiary->isHomeless = $data['isHomeless'] ?? $beneficiary->isHomeless;
                    break;
                }
            }

            return true;
        } catch (Exception $e) {
            // Rollback transaction if something failed
            $db->rollBack();
            // Log the error or handle it as needed
            error_log("Error updating beneficiary: " . $e->getMessage());
            return false;
        }
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
