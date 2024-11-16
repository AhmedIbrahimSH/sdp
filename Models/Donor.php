<?php
require_once("Database.php");

class Donor
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }





    // Method to get a specific donor by PersonID
    public function getDonor($id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            p.PersonID, 
            p.FirstName, 
            p.LastName, 
            p.MiddleName, 
            p.Nationality, 
            p.Gender, 
            p.PersonPhone, 
            a.AccountEmail, 
            a.AccountPasswordHashed, 
            a.Status, 
            a.IsUser, 
            a.IsAccountDeleted, 
            d.BloodType, 
            d.IsDonorDeleted
        FROM Person p
        INNER JOIN Account a ON p.PersonID = a.PersonID
        INNER JOIN Donor d ON p.PersonID = d.PersonID
        WHERE p.PersonID = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    // Method to retrieve all donors
    public function getAllDonors()
    {
        $stmt = $this->db->query("
        SELECT 
            d.PersonID, 
            p.FirstName, 
            p.LastName, 
            p.MiddleName, 
            p.Nationality, 
            p.Gender, 
            p.PersonPhone, 
            a.AccountEmail, 
            a.AccountPasswordHashed, 
            a.Status, 
            a.IsUser, 
            a.IsAccountDeleted, 
            d.BloodType, 
            d.IsDonorDeleted
        FROM 
            Donor d
        INNER JOIN Person p ON d.PersonID = p.PersonID
        INNER JOIN Account a ON d.PersonID = a.PersonID
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }







    // Method to add a new donor
    public function addDonor($data)
    {

        try {
            // Validate required fields
            if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email']) || empty($data['city'])) {
                throw new Exception("Missing required fields in data.");
            }

            $this->db->beginTransaction();

            // Insert into Address table

            $BloodType = !empty($data['bloodType']) ? $data['bloodType'] : NULL;
            $stmt = $this->db->prepare("
            INSERT INTO Address 
            (City, Country, Street)
            VALUES (?, ?, ?)
        ");
            $stmt->execute([
                $data['city'],
                $data['country'],
                $data['street'],

            ]);
            $addressID = $this->db->lastInsertId();
            if (!$addressID) {
                throw new Exception("Failed to insert address.");
            }

            // Insert into Person table
            $middleName = !empty($data['middleName']) ? $data['middleName'] : NULL;
            $stmt = $this->db->prepare("
            INSERT INTO Person 
            (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID) 
            VALUES (?, ?, ?, ?, ?, ?, 0, ?)
        ");
            $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $middleName,
                $data['nationality'],
                $data['gender'],
                $data['phone'],
                $addressID
            ]);
            $personID = $this->db->lastInsertId();
            if (!$personID) {
                throw new Exception("Failed to insert person.");
            }

            // Insert into Account table
            $stmt = $this->db->prepare("
            INSERT INTO Account 
            (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted) 
            VALUES (?, ?, ?, 'Active', 1, 0)
        ");
            $stmt->execute([
                $personID,
                $data['email'],
                $data['password']
            ]);

            // Insert into Donor table
            $stmt = $this->db->prepare("
            INSERT INTO Donor 
            (PersonID, BloodType, IsDonorDeleted) 
            VALUES (?, ?, 0)
        ");
            $stmt->execute([
                $personID,
                $BloodType
            ]);

            $this->db->commit();
            return $personID;


        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }

    }






    // Method to update donor details
    public function updateDonor($personID, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE Person p
        INNER JOIN Account a ON p.PersonID = a.PersonID
        INNER JOIN Donor d ON p.PersonID = d.PersonID
        SET 
            p.FirstName = ?, 
            p.LastName = ?, 
            p.MiddleName = ?, 
            p.Nationality = ?, 
            p.Gender = ?, 
            p.PersonPhone = ?, 
            a.AccountEmail = ?, 
            a.AccountPasswordHashed = IF(? = '', a.AccountPasswordHashed, ?), 
            a.Status = ?, 
            a.IsUser = ?, 
            a.IsAccountDeleted = ?, 
            d.BloodType = ?, 
            d.IsDonorDeleted = ?
        WHERE p.PersonID = ?
    ");
        $stmt->execute([
            $data['firstName'],
            $data['lastName'],
            $data['middleName'],
            $data['nationality'],
            $data['Gender'],
            $data['PersonPhone'],
            $data['AccountEmail'],
            $data['AccountPasswordHashed'], // Password placeholder
            $data['password'], // Password update
            $data['status'],
            $data['isUser'],
            $data['isAccountDeleted'],
            $data['bloodType'],
            $data['isDonorDeleted'],
            $personID
        ]);
    }






    // Method to delete a donor
    public function deleteDonor($personID)
    {
        $stmt = $this->db->prepare("UPDATE Donor SET IsDonorDeleted = 1 WHERE PersonID = ?");
        $stmt->execute([$personID]);
        return $stmt->rowCount();
    }

    // Method to retrieve all donations made by a donor
    public function getDonationsByDonor($donorID)
    {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM Donations 
            WHERE DonorID = ?
        ");
        $stmt->execute([$donorID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
