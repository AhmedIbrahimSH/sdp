<?php
require_once 'Database.php';
require_once 'Person.php';
require_once 'Account.php';
require_once 'VolunteerTracker.php'; // Include the VolunteerTracker class
require_once 'VolunteerObserver.php';
class  Volunteer extends Account implements VolunteerObserver {

    private $tracker; // Aggregation: VolunteerTracker instance

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->tracker = new VolunteerTracker($this->personId); // Initialize the tracker
    }



    // Database CRUD operations for Volunteer and Person

    public function getAllVolunteers() {
        $stmt = $this->db->prepare("
        SELECT 
            v.PersonID AS PersonID, 
            p.FirstName, 
            p.LastName, 
            p.Nationality, 
            p.Gender, 
            p.Phone
        FROM Volunteer v
        JOIN Person p ON v.PersonID = p.PersonID
        WHERE v.IsVolunteerDeleted = 0
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
            INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
            VALUES (:firstName, :lastName, :middleName, :nationality, :gender, :phone, :addressId)
        ");
            $stmt->execute([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'middleName' => $data['middleName'] ?? null,
                'nationality' => $data['nationality'] ?? null,
                'gender' => $data['gender'],
                'phone' => $data['phone'],
                'addressId' => $data['addressId'] ?? 1 // Use provided addressId or default to 1
            ]);
            $personId = $this->db->lastInsertId(); // Get the newly created PersonID

            // Step 2: Create Account
            $stmt = $this->db->prepare("
            INSERT INTO Account (PersonID, Email, PasswordHashed, Account_Type)
            VALUES (:personId, :email, :passwordHashed, :Account_Type)
        ");
            $stmt->execute([
                'personId' => $personId,
                'email' => $data['email'],
                'passwordHashed' => $data['passwordHashed'], // Use the hashed password
                'Account_Type' => 'Volunteer' // Default to 'Volunteer' if not provided
            ]);

            // Step 3: Create Volunteer
            $stmt = $this->db->prepare("
            INSERT INTO Volunteer (PersonID)
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
            SELECT v.PersonID, p.FirstName, p.LastName, a.Email, p.Phone, p.AddressID, p.MiddleName, p.Nationality, p.Gender, p.Phone
            FROM volunteer v
            JOIN person p ON v.PersonID = p.PersonID 
            JOIN Account a ON  a.PersonID = p.PersonID
            WHERE v.PersonID = :id AND v.IsVolunteerDeleted = 0
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
            Phone = :phone,
            AddressID = :addressId
        WHERE PersonID = :id
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
            Email = :email
        WHERE PersonID = :id
    ");
        $stmt->execute([
            'email' => $data['email'],
            'id' => $id
        ]);

        // Update Volunteer table (if necessary)
        if (isset($data['isVolunteerDeleted'])) {
            $stmt = $this->db->prepare("
            UPDATE Volunteer 
            SET IsVolunteerDeleted = :isVolunteerDeleted
            WHERE PersonID = :id
        ");
            $stmt->execute([
                'isVolunteerDeleted' => $data['isVolunteerDeleted'],
                'id' => $id
            ]);
        }
    }


    public function deleteVolunteer($id) {
        $stmt = $this->db->prepare("
            UPDATE Volunteer 
            SET IsVolunteerDeleted = 1
            WHERE PersonID = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($eventType, $eventDetails, $PersonID) {
        if ($this->personId === $PersonID) { // Notify only the intended volunteer
            $logMessage = "Notification for Volunteer (Person ID: {$this->personId}): ";
            $logMessage .= "A new {$eventType} has been created: {$eventDetails['EventName']} on {$eventDetails['EventDate']}.\n";

            // Write the log message to notifications.log
            file_put_contents('notifications.log', $logMessage, FILE_APPEND);
        }
    }

    public function subscribeToEvent($personId, $eventType) {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Subscriptions (PersonID, event_type)
            VALUES (:PersonID, :event_type)
            ON DUPLICATE KEY UPDATE event_type = :event_type
        ");
        $stmt->execute([
            'PersonID' => $personId,
            'event_type' => $eventType
        ]);
    }
}
?>
