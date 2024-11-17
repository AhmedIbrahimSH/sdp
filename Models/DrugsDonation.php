<?php
require_once("Database.php");

class DrugsDonation implements DonationStrategy
{
    private $db;

    private $amount;
    private $quantity;

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function processDonation($id,$amount,$quantity){

         $this->addDonation($id,$amount);
    }
    public function setDrugDetails($type, $amount, $quantity)
    {

        $this->amount = $amount;
        $this->quantity = $quantity;
    }


    public function setAmount($amount){
        $this->amount = $amount;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function addDonation($donationID, $quantity, $amount)
    {
        $sql = "INSERT INTO DrugsDonation (DonationID, Quantity, Amount) 
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
        $sql = "SELECT * FROM DrugsDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDonations()
    {
        $sql = "SELECT * FROM DrugsDonation";
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

        $sql = "UPDATE DrugsDonation SET $setClause WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':donationID', $donationID);

        $stmt->execute();
    }

    public function deleteDonation($donationID)
    {
        $sql = "DELETE FROM DrugsDonation WHERE DonationID = :donationID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':donationID' => $donationID]);
    }
}