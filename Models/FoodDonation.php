<?php
require_once("Database.php");

class FoodDonation implements DonationStrategy
{
    private $db;
    private $amount;
    private $quantity;

    /**
     * Constructor to initialize the database connection.
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Process donation data
    public function processDonation($id,$amount,$quantity)
    {
        return [
            'amount' => $this->getAmount(),
            'quantity' => $this->getQuantity()
        ];
    }

    // Setters and Getters
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    // Add a new food donation
    public function addFoodDonation($donationID, $quantity, $amount)
    {
        $sql = "INSERT INTO FoodDonation (DonationID, Quantity, Amount) 
                VALUES (:donationID, :quantity, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':donationID' => $donationID,
            ':quantity' => $quantity,
            ':amount' => $amount,
        ]);
    }

    // Get a specific food donation by ID
    public function getDonation($donationID)
    {
        $sql = "SELECT * FROM FoodDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all food donations
    public function getAllDonations()
    {
        $sql = "SELECT * FROM FoodDonation";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an existing food donation
    public function updateDonation($donationID, $fields)
    {
        $setClause = [];
        foreach ($fields as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE FoodDonation SET $setClause WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':donationID', $donationID);

        $stmt->execute();
    }

    // Delete a food donation
    public function deleteDonation($donationID)
    {
        $sql = "DELETE FROM FoodDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
    }
}
