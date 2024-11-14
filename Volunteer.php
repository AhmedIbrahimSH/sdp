<?php
require_once 'Database.php';
require_once 'Person.php';
require_once 'VolunteerTracker.php'; // Include the VolunteerTracker class

class  Volunteer extends Person {
    private $db;

    // Properties corresponding to database columns
    private $id;
    private $person_id;
    private $phone;
    private $address;
    private $joined_date;
    private $role;
    private $status;
    private $tracker; // Aggregation: VolunteerTracker instance

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->tracker = new VolunteerTracker(); // Initialize the tracker
    }

    // Getters and setters for each property
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPersonId() {
        return $this->person_id;
    }

    public function setPersonId($person_id) {
        $this->person_id = $person_id;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getJoinedDate() {
        return $this->joined_date;
    }

    public function setJoinedDate($joined_date) {
        $this->joined_date = $joined_date;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    // Access to VolunteerTracker
    public function getTracker() {
        return $this->tracker;
    }

    // Database CRUD operations for Volunteer and Person

    public function getAllVolunteers() {
        $stmt = $this->db->prepare("
            SELECT v.id, v.person_id, p.name, p.email, v.phone, v.address, v.joined_date, v.role, v.status
            FROM volunteers v
            JOIN persons p ON v.person_id = p.person_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPerson($data) {
        $stmt = $this->db->prepare("INSERT INTO persons (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $data['name'], 'email' => $data['email']]);
        return $this->db->lastInsertId();  // Return person_id
    }

    public function createVolunteer($data) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteers (person_id, phone, address, joined_date, role, status)
            VALUES (:person_id, :phone, :address, :joined_date, :role, :status)
        ");
        return $stmt->execute($data);
    }

    public function getVolunteerById($id) {
        $stmt = $this->db->prepare("
            SELECT v.id, v.person_id, p.name, p.email, v.phone, v.address, v.joined_date, v.role, v.status
            FROM volunteers v
            JOIN persons p ON v.person_id = p.person_id
            WHERE v.id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePerson($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE persons SET name = :name, email = :email
            WHERE person_id = (SELECT person_id FROM volunteers WHERE id = :id)
        ");
        $stmt->execute(['name' => $data['name'], 'email' => $data['email'], 'id' => $id]);
    }

    public function updateVolunteer($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE volunteers SET phone = :phone, address = :address, joined_date = :joined_date, role = :role, status = :status
            WHERE id = :id
        ");
        $stmt->execute(array_merge(['id' => $id], $data));
    }

    public function deleteVolunteer($id) {
        $stmt = $this->db->prepare("
            DELETE FROM persons WHERE person_id = (SELECT person_id FROM volunteers WHERE id = :id)
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
