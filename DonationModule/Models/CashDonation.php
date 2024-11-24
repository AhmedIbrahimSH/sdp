<?php

namespace Models;

require_once("Database.php");
require_once("DonationStrategy.php");

class CashDonation implements DonationStrategy
{
    private $CashNeed;
    private $amount;
    //   private $currency;

    private $db;
    private $quantity = 1;

    /**
     * @param $db
     */

    private $model;

    public function __construct($model)
    {
        $this->model = $model; // Model is responsible for database interactions
    }

    public function setData($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTotalAmount()
    {
        return $this->amount;
    }

    public function getQuantity()
    {
        return 1;
    }

    public function getDonationDetails()
    {
        return [
            'amount' => $this->getAmount(),
            'totalAmount' => $this->getTotalAmount(),
            'quantity' => $this->getQuantity(),
        ];
    }

    public function myprint()
    {
        print("CASH");
    }

    public function processDonation($id, $quantity)
    {
        // $this->addDonation($id,$amount,1);
    }

    public function setCashAmount($amount)
    {
        $this->amount = $amount;
    }


    public function addDonation($donationID, $amount, $quantity)
    {
        $sql = "INSERT INTO CashDonation (DonationID, Amount) 
                VALUES (:donationID, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':donationID' => $donationID,
            ':amount' => $amount,
        ]);
    }

    public function getDonationById($donationID)
    {
        $sql = "SELECT * FROM CashDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDonations()
    {
        try {

            $stmt = $this->db->query("SELECT * FROM CashDonation");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching donations: " . $e->getMessage());
        }
    }

    public function updateDonation($donationID, $fields)
    {
        $setClause = [];
        foreach ($fields as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE CashDonation SET $setClause WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':donationID', $donationID);

        $stmt->execute();
    }

    // Delete Cash Donation
    public function deleteDonation($donationID)
    {
        $sql = "DELETE FROM CashDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
    }

}