<?php
require_once 'Database.php';

class Volunteer {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllVolunteers() {
        $stmt = $this->db->prepare("SELECT * FROM volunteers");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVolunteerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM volunteers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createVolunteer($data) {
        $stmt = $this->db->prepare("INSERT INTO volunteers (name, email, phone, address, joined_date, role, status) VALUES (:name, :email, :phone, :address, :joined_date, :role, :status)");
        return $stmt->execute($data);
    }

    public function updateVolunteer($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE volunteers SET name = :name, email = :email, phone = :phone, address = :address, joined_date = :joined_date, role = :role, status = :status WHERE id = :id");
        return $stmt->execute($data);
    }

    public function deleteVolunteer($id) {
        $stmt = $this->db->prepare("DELETE FROM volunteers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
