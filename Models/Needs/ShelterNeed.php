<?php
require_once 'NeedTemplateMethod.php';

class ShelterNeed extends NeedTemplateMethod
{
    function checkEligibility($beneficiary)
    {
        return $beneficiary->isHomeless();
    }

    protected function register($beneficiary, $place = 1)
    {
        // Prepare the SQL query with placeholders to prevent SQL injection
        $query = "INSERT INTO ShelterNeedHistory (BeneficiaryID, Place, Allocated)
              VALUES (?, ?, FALSE)";

        // Use a prepared statement
        if ($stmt = mysqli_prepare($this->dbConnection, $query)) {
            // Bind the parameters (i for integer, d for double, s for string, etc.)
            mysqli_stmt_bind_param($stmt, 'ii', $beneficiary->getPersonID(), $place);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                // Close the statement
                mysqli_stmt_close($stmt);
                return true; // Return true on success
            } else {
                // Handle execution errors
                error_log("Error executing query: " . mysqli_error($this->dbConnection));
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle preparation errors
            error_log("Error preparing query: " . mysqli_error($this->dbConnection));
        }

        return false; // Return false on failure

    }

    protected function allocateResources($beneficiary)
    {
        // Example: Allocate shelter resources to the beneficiary
        echo "Allocated shelter for " . $beneficiary->getName() . "\n";
    }

    protected function checkResources($amount)
    {
        // Example: Check if there are enough shelter resources for the beneficiary
        echo "Checking shelter resources \n";
        return true; // Assuming resources are available
    }

    protected function getNeedType()
    {
        return "Shelter";
    }
}
