<?php

namespace DonationModule\Models;

use Models\PDO;

require_once("Database.php");

class FoodDonation implements DonationStrategy
{
    private $db;
    private $quantity;

    private $amount;

    private $model;

    private const PREDEFINED_AMOUNT_PER_ITEM = 200.00;

    public function getPREDEFINEDAMOUNTPERITEM(): float
    {
        return self::PREDEFINED_AMOUNT_PER_ITEM;
    }

    /**
     * @return mixed
     */

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    } // Fixed amount per item

    /**
     * Constructor to initialize the database connection.
     *
     * @param $db PDO Database connection
     */
    public function __construct($model)
    {
        $this->model = $model; // Model is responsible for database interactions
    }

    public function __sleep()
    {
        // Exclude the PDO object and return serializable properties
        return ['quantity', 'amount'];
    }

    public function __wakeup()
    {
        // Reinitialize the PDO object or any other non-serializable properties
        $this->db = Database::getInstance(); // Reinitialize the database connection
    }

    public function myprint()
    {
        print("FOOD");
    }

    /**
     * Process a food donation.
     *
     * @param int $donationID
     * @param int $quantity
     * @return string Confirmation message
     */
    public function processDonation($donationID, $quantity)
    {
        // Calculate total amount using predefined amount per item
        $totalAmount = $quantity * $this->getPREDEFINEDAMOUNTPERITEM();

        // Add the donation to the database
        $this->addFoodDonation($donationID, $quantity, $totalAmount);

        return "Processed Food Donation: DonationID = $donationID, Quantity = $quantity, Total Amount = $totalAmount";
    }


    public function setData($quantity)
    {
        $this->setQuantity($quantity);
        $this->setTotalAmount($quantity);

    }

    public function setTotalAmount($quantity)
    {
        $this->amount = $this->getAmount() * $this->getQuantity();
    }

    public function getAmount()
    {
        return self::PREDEFINED_AMOUNT_PER_ITEM;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getTotalAmount()
    {

        return $this->getAmount() * $this->getQuantity();
    }

    public function getDonationDetails()
    {
        return [
            'amount' => $this->getAmount(),
            'totalAmount' => $this->getTotalAmount(),
            'quantity' => $this->getQuantity(),
        ];
    }

    /**
     * Add a new food donation.
     *
     * @param int $donationID
     * @param int $quantity
     * @param float $totalAmount
     */
    private function addFoodDonation($donationID, $quantity, $totalAmount)
    {
        $sql = "INSERT INTO FoodDonation (DonationID, Quantity, Amount) 
                VALUES (:donationID, :quantity, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':donationID' => $donationID,
            ':quantity' => $quantity,
            ':amount' => $totalAmount,
        ]);
    }

    /**
     * Get a specific food donation by its ID.
     *
     * @param int $donationID
     * @return array|false
     */
    public function getDonation($donationID)
    {
        $sql = "SELECT * FROM FoodDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all food donations.
     *
     * @return array
     */
    public function getAllDonations()
    {
        $sql = "SELECT * FROM FoodDonation";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update an existing food donation.
     *
     * @param int $donationID
     * @param array $fields Key-value pairs to update
     */
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

    /**
     * Delete a food donation by its ID.
     *
     * @param int $donationID
     */
    public function deleteDonation($donationID)
    {
        $sql = "DELETE FROM FoodDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
    }
}
