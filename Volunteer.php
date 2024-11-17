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


    public function createVolunteer($data) {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // Step 1: Create Person
            $stmt = $this->db->prepare("
            INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
            VALUES (:firstName, :lastName, :middleName, :nationality, :gender, :phone, :addressId)
        ");
            $stmt->execute([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'middleName' => $data['middleName'] ?? null,
                'nationality' => $data['nationality'] ?? null,
                'gender' => $data['gender'],
                'phone' => $data['phone'],
                'addressId' => 1
            ]);
            $personId = $this->db->lastInsertId(); // Get the newly created person_id

            // Step 2: Create Account
            $stmt = $this->db->prepare("
            INSERT INTO Account (person_id, AccountEmail, Status)
            VALUES (:personId, :email, :status)
        ");
            $stmt->execute([
                'personId' => $personId,
                'email' => $data['email'],
                'status' => $data['status']
            ]);

            // Step 3: Create Volunteer
            $stmt = $this->db->prepare("
            INSERT INTO Volunteer (person_id)
            VALUES (:personId)
        ");
            $stmt->execute(['personId' => $personId]);

            // Commit transaction
            $this->db->commit();

            return $personId;
        } catch (Exception $e) {
            // Rollback on failure
            $this->db->rollBack();
            throw $e;
        }
    }


    public function getVolunteerById($id) {
        $stmt = $this->db->prepare("
            SELECT v.person_id, p.FirstName, p.LastName, a.AccountEmail, p.PersonPhone, p.AddressID, p.MiddleName, p.Nationality, p.Gender, p.PersonPhone, a.Status
            FROM volunteer v
            JOIN person p ON v.person_id = p.person_id 
            JOIN Account a ON  a.person_id = p.person_id
            WHERE v.person_id = :id AND v.IsVolunteerDeleted = 0
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function updateVolunteer($id, $data) {
        // Update Person table
        $stmt = $this->db->prepare("
        UPDATE Person 
        SET 
            FirstName = :firstName,
            LastName = :lastName,
            MiddleName = :middleName,
            Nationality = :nationality,
            Gender = :gender,
            PersonPhone = :phone,
            AddressID = :addressId
        WHERE person_id = :id
    ");
        $stmt->execute([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'middleName' => $data['middleName'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'addressId' => 1,
            'id' => $id
        ]);

        // Update Account table
        $stmt = $this->db->prepare("
        UPDATE Account 
        SET 
            AccountEmail = :email,
            Status = :status
        WHERE person_id = :id
    ");
        $stmt->execute([
            'email' => $data['email'],
            'status' => $data['status'],
            'id' => $id
        ]);

        // Update Volunteer table (if necessary)
        if (isset($data['isVolunteerDeleted'])) {
            $stmt = $this->db->prepare("
            UPDATE Volunteer 
            SET IsVolunteerDeleted = :isVolunteerDeleted
            WHERE person_id = :id
        ");
            $stmt->execute([
                'isVolunteerDeleted' => $data['isVolunteerDeleted'],
                'id' => $id
            ]);
        }
    }


    public function deleteVolunteer($id) {
        $stmt = $this->db->prepare("
            DELETE FROM person WHERE person_id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
