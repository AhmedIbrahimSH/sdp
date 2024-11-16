<?php
require_once 'Database.php';
require_once 'Person.php';
require_once 'Account.php';
require_once 'VolunteerTracker.php'; // Include the VolunteerTracker class

class  Volunteer extends Account {

    private $tracker; // Aggregation: VolunteerTracker instance

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->tracker = new VolunteerTracker($this->personId); // Initialize the tracker
    }



    // Database CRUD operations for Volunteer and Person

    public function getAllVolunteers() {
        $stmt = $this->db->prepare("
        SELECT 
            v.person_id AS person_id, 
            p.FirstName, 
            p.LastName, 
            p.Nationality, 
            p.Gender, 
            p.PersonPhone
        FROM Volunteer v
        JOIN Person p ON v.person_id = p.person_id
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createPerson($data) {
        $stmt = $this->db->prepare("INSERT INTO person (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $data['name'], 'email' => $data['email']]);
        return $this->db->lastInsertId();  // Return person_id
    }

    public function createVolunteer($data) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteer (person_id, phone, address, joined_date, role, status)
            VALUES (:person_id, :phone, :address, :joined_date, :role, :status)
        ");
        return $stmt->execute($data);
    }

    public function getVolunteerById($id) {
        $stmt = $this->db->prepare("
            SELECT v.id, v.person_id, p.name, p.email, v.phone, v.address, v.joined_date, v.role, v.status
            FROM volunteer v
            JOIN person p ON v.person_id = p.person_id
            WHERE v.person_id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function updateVolunteer($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE volunteer SET phone = :phone, address = :address, joined_date = :joined_date, role = :role, status = :status
            WHERE id = :id
        ");
        $stmt->execute(array_merge(['id' => $id], $data));
    }

    public function deleteVolunteer($id) {
        $stmt = $this->db->prepare("
            DELETE FROM person WHERE person_id = (SELECT person_id FROM volunteer WHERE id = :id)
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
