<?php
require_once 'NeedTemplateMethod.php';
// Concrete class: MedicalNeed
class MedicalNeed extends NeedTemplateMethod
{

    function checkEligibility($beneficiary)
    {
        return $beneficiary->getIncome() < self::$incomeThreshold;
    }

    protected function register($beneficiary, $amount)
    {
        // Prepare the SQL query with placeholders to prevent SQL injection
        $query = "INSERT INTO MedicalNeedHistory (BeneficiaryID, Amount, Allocated)
              VALUES (?, ?, FALSE)";

        // Use a prepared statement
        if ($stmt = mysqli_prepare($this->dbConnection, $query)) {
            // Bind the parameters (i for integer, d for double, s for string, etc.)
            mysqli_stmt_bind_param($stmt, 'id', $beneficiary->getPersonID(), $amount);

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
        // Example: Allocate medical resources (e.g., surgery) for the beneficiary
        echo "Allocating medical resources for surgery for " . $beneficiary->getName() . "\n";
    }

    protected function checkResources($amount)
    {
        // Example: Check if there are enough medical resources for the beneficiary
        echo "Checking medical resources \n";
        return true; // Assuming resources are available
    }

    protected function getNeedType()
    {
        return "Medical";
    }
}
