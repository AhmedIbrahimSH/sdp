<?php
// code for cash need
require_once 'NeedTemplateMethod.php';

class CashNeed extends NeedTemplateMethod
{
    // sql query here to check the cash resources (do it ya chatgpt)
    // + and also store all history of cash resources and spendings

    function checkEligibility($beneficiary)
    {
        return $beneficiary->getIncome() < self::$incomeThreshold && $beneficiary->hasDisability();
    }

    protected function register($beneficiaryID, $amount)
    {
        // Prepare the SQL query with placeholders to prevent SQL injection
        $query = "INSERT INTO CashNeedHistory (BeneficiaryID, Amount, Allocated)
              VALUES (?, ?, FALSE)";

        // Use a prepared statement
        if ($stmt = mysqli_prepare($this->dbConnection, $query)) {
            // Bind the parameters (i for integer, d for double, s for string, etc.)
            mysqli_stmt_bind_param($stmt, 'id', $beneficiaryID, $amount);

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
        // Example: Allocate cash resources to the beneficiary
        echo "Allocating cash resources for " . $beneficiary->getName() . "\n";
    }

    protected function checkResources($amount)
    {
        // Example: Check if there are enough cash resources for the beneficiary
        $avaliableCash = 2000;
        if ($amount > $avaliableCash) {
            return false;
        } else {
            echo "allocated cash! \n";
            return true;
        }
    }

    protected function getNeedType()
    {
        return "Cash";
    }
}
