<?php

namespace Models;

require_once("Database.php");

class ClothesDonation implements DonationStrategy
{
    private $db;
    private $amount;
    private $quantity;

    /**
     * @param $db
     */

    private $model;

    public function myprint()
    {
        print("CLOTHES");
    }

    public function __construct($model)
    {
        $this->model = $model; // Model is responsible for database interactions
    }

    private const PREDEFINED_AMOUNT_PER_ITEM = 200.00;

    public function getPREDEFINEDAMOUNTPERITEM(): float
    {
        return self::PREDEFINED_AMOUNT_PER_ITEM;
    }

    public function processDonation($id, $quantity)
    {
        $totalAmount = $quantity * self::PREDEFINED_AMOUNT_PER_ITEM;
        $this->addDonation($id, $quantity, $totalAmount);
    }


    public function setData($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    public function addDonation($donationID, $quantity, $amount)
    {
        $sql = "INSERT INTO ClothesDonation (DonationID, Quantity, Amount) 
                VALUES (:donationID, :quantity, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':donationID' => $donationID,
            ':quantity' => $quantity,
            ':amount' => $amount,
        ]);
    }

    public function getDonationById($donationID)
    {
        $sql = "SELECT * FROM ClothesDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDonations()
    {
        $sql = "SELECT * FROM ClothesDonation";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDonation($donationID, $fields)
    {
        $setClause = [];
        foreach ($fields as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE ClothesDonation SET $setClause WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':donationID', $donationID);

        $stmt->execute();
    }

    public function deleteDonation($donationID)
    {
        $sql = "DELETE FROM ClothesDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
    }

}