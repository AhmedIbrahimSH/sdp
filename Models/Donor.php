<?php
require_once("Database.php");


class Donor
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Method to get a specific donor by ID
    public function getDonor($id) {
        $stmt = $this->db->prepare("SELECT * FROM donors WHERE personID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Method to retrieve all donors
    public function getAllDonors() {
        $stmt = $this->db->query("SELECT * FROM donors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new donor
    public function addDonor($data) {
        $stmt = $this->db->prepare("INSERT INTO donors (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address']]);
        return $stmt->rowCount();
    }
    public function updateDonor($id, $data) {
        $stmt = $this->db->prepare("UPDATE donors SET name = ?, email = ?, phone = ?, address = ? WHERE personID = ?");
        $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $id]);
    }
    // Delete a donor by ID
    public function deleteDonor($id) {
        $stmt = $this->db->prepare("DELETE FROM donors WHERE personID = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
    // Retrieve all donations associated with a specific donor
    public function getDonationsByDonor($donorID) {
        $stmt = $this->db->prepare("SELECT * FROM donations WHERE donorID = ?");
        $stmt->execute([$donorID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}