<?php
require_once 'NeedTemplateMethod.php';
// Concrete class: MedicalNeed
class MedicalNeed extends NeedTemplateMethod
{

    function checkEligibility($beneficiary)
    {
        return $beneficiary->getIncome() < self::getIncomeThreshold();
    }

    protected function register($beneficiaryID, $amount, $accepted)
    {
        // Check if the beneficiary ID already exists in the MedicalNeedHistory table to update accpeted column
        $query = "SELECT COUNT(*) FROM MedicalNeedHistory WHERE BeneficiaryID = ? AND Accepted = 0";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            if ($accepted) {
                // Beneficiary ID already exists, update the accepted column to TRUE
                $query = "UPDATE MedicalNeedHistory SET Accepted = 1 WHERE BeneficiaryID = ? AND Accepted = 0";
                $stmt = $this->dbConnection->prepare($query);
                $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true; // Return true on success
                } else {
                    // Handle execution errors
                    error_log("Error executing update query: " . implode(", ", $stmt->errorInfo()));
                }
            } else {
                echo "Beneficiary need Rejected";
            }
        } else {



            // If the beneficiary ID does not exist, insert the data
            $query = "INSERT INTO MedicalNeedHistory (BeneficiaryID, Amount, Allocated, Accepted)
          VALUES (?, ?, ?, ?)";
            $stmt = $this->dbConnection->prepare($query);
            $accepted = (bool) $accepted; // Make sure it's a boolean
            $allocated = 0; // Variable for allocated
            $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT); // Bind beneficiary ID as an integer
            $stmt->bindParam(2, $amount, PDO::PARAM_STR);        // Bind amount (adjust type if necessary)
            $stmt->bindParam(3, $allocated, PDO::PARAM_BOOL);    // Bind allocated as a boolean
            $stmt->bindParam(4, $accepted, PDO::PARAM_BOOL);    // Bind accepted as a boolean

            if ($stmt->execute()) {
                return true; // Return true on success
            } else {
                // Handle execution errors
                error_log("Error executing query: " . implode(", ", $stmt->errorInfo()));
            }

            return false;
        }
    }

    protected function allocateResources($table, $beneficiaryID)
    {
        // Get the needed amount
        $query = "SELECT Amount FROM $table WHERE BeneficiaryID = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT); // Beneficiary ID for WHERE clause
        $stmt->execute();
        $needed_amount = $stmt->fetchColumn();

        // Mark the row as allocated
        $query = "UPDATE $table SET Allocated = 1 WHERE BeneficiaryID = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT); // Beneficiary ID for WHERE clause
        $stmt->execute();

        // Update the charity storage
        $query = "UPDATE charity_storage SET Amount = Amount - ?, Spendings = Spendings + ?, AffectedPeople = AffectedPeople + ? WHERE type = 'Medical'";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $needed_amount, PDO::PARAM_STR); // Amount to subtract
        $stmt->bindParam(2, $needed_amount, PDO::PARAM_STR); // Amount to add to spendings
        $affectedPeople = 1; // Fixed number of affected people
        $stmt->bindParam(3, $affectedPeople, PDO::PARAM_INT); // Number of affected people
        $stmt->execute();

        return true;
    }

    protected function checkResources($table, $beneficiaryID)
    {
        // Extract the need type (e.g., 'Cash' from 'cashneedhistory')
        $needType = explode('needhistory', strtolower($table))[0];

        // Get available amount for the need type
        $query = "SELECT Amount FROM charity_storage WHERE type = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $needType, PDO::PARAM_STR); // Bind need type
        $stmt->execute();
        $available_amount = $stmt->fetchColumn();

        // Get needed amount for the beneficiary
        $query = "SELECT Amount FROM $table WHERE BeneficiaryID = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(1, $beneficiaryID, PDO::PARAM_INT); // Bind Beneficiary ID
        $stmt->execute();
        $needed_amount = $stmt->fetchColumn();

        // Compare available and needed amounts
        return $available_amount >= $needed_amount;
    }

    protected function getNeedType()
    {
        return "Medical";
    }
}
