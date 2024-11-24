<?php

namespace Models;

require_once("Database.php");

class Donation
{

    protected $DonationDate;
    protected $amount;

    private $quantity;

    private $strategy;
    private $DonationID;

    private $data;
    protected $totalAmmount;
    private $db;

    /**
     * @return mixed
     */
//    public function getDb()
//    {
//        return $this->db;
//    }
    public function __construct($db)
    {
        $this->db = $db;
        // Additional initialization for the Donation class, if needed
    }

    public function __sleep()
    {
        // Exclude the PDO object and return serializable properties
        return array_keys(get_object_vars($this)); // Remove `$db` from the serialized data
    }

    public function __wakeup()
    {
        // Reinitialize the PDO object or any other non-serializable properties
        $this->db = Database::getInstance(); // Reinitialize the database connection
    }

    public function setstrategy($strategy)
    {
        $this->strategy = $strategy;

    }

    public function returnStrategytype()
    {
        print"lol";
    }

    public function sendDataToStrategy($data)
    {
        $this->strategy->setData($data);
    }

    public function receiveDatafromstrategy()
    {
        return $this->strategy->getDonationDetails();
    }


    public function getAmount()
    {
        return $this->amount;
    }

    public function getDescription()
    {
        return "Base Donation";
    }

    public function applyDonationStrategy($id, $data, $quantity)
    {
        $this->strategy->processDonation($id, $data, $quantity);

    }


    /**
     * @return mixed
     */
    public function getStrategy()
    {
        return $this->strategy;
    }


    public function addDonation($type, $date, $paymentMethod, $totalAmount, $personID)
    {
        try {
            $query = "
                INSERT INTO Donation (DonationType, DonationDate, PaymentMethod, TotalAmount, PersonID) 
                VALUES (:type, :date, :paymentMethod, :totalAmount, :personID)
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_STR);
            $stmt->bindParam(':totalAmount', $totalAmount, PDO::PARAM_STR);
            $stmt->bindParam(':personID', $personID, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log it, or rethrow it as needed
            throw new Exception("Error adding donation: " . $e->getMessage());
        }
    }


// Read Donation
    function getDonation($donationID)
    {
        // SQL SELECT query
    }

    public function getAllDonations()
    {

        try {
            $stmt = $this->db->query("SELECT * FROM Donation"); // SQL query to get all donations
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array
        } catch (Exception $e) {
            throw new Exception("Error fetching donations: " . $e->getMessage());
        }
    }

//getDonationById
    public function getDonationById($donationID)
    {
        try {
            $query = "SELECT * FROM Donation WHERE DonationID = :donationID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':donationID', $donationID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error retrieving donation: " . $e->getMessage());
        }
    }


// Update Donation
    public function updateDonation($donationID, $type, $date, $paymentMethod, $totalAmount, $personID)
    {
        try {
            $query = "
                UPDATE Donation 
                SET DonationType = :type, DonationDate = :date, PaymentMethod = :paymentMethod, 
                    TotalAmount = :totalAmount, PersonID = :personID 
                WHERE DonationID = :donationID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_STR);
            $stmt->bindParam(':totalAmount', $totalAmount, PDO::PARAM_STR);
            $stmt->bindParam(':personID', $personID, PDO::PARAM_INT);
            $stmt->bindParam(':donationID', $donationID, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating donation: " . $e->getMessage());
        }
    }


// Delete Donation

    public function deleteDonation($donationID)
    {
        try {
            $query = "DELETE FROM Donation WHERE DonationID = :donationID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':donationID', $donationID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting donation: " . $e->getMessage());
        }
    }


}
