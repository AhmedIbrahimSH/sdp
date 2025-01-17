<?php

namespace Models;
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
            p.Phone, 
            p.AddressID, 
            a.Email, 
            a.PasswordHashed, 
            a.IsUser, 
            a.IsAccountDeleted, 
            d.IsDonorDeleted, 
            addr_country.Name AS Country, 
            addr_city.Name AS City, 
            addr_street.Name AS Street
        FROM Person p
        INNER JOIN Account a ON p.PersonID = a.PersonID
        INNER JOIN Donor d ON p.PersonID = d.PersonID
        LEFT JOIN Address addr_street ON p.AddressID = addr_street.AddressID
        LEFT JOIN Address addr_city ON addr_street.ParentID = addr_city.AddressID
        LEFT JOIN Address addr_country ON addr_city.ParentID = addr_country.AddressID
        WHERE p.PersonID = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    // Method to retrieve all donors
    public function getAllDonors()
    {
        $stmt = $this->db->query("
        SELECT 
            p.PersonID, 
            p.FirstName, 
            p.LastName, 
            p.MiddleName, 
            p.Nationality, 
            p.Gender, 
            p.Phone, 
            a.Email, 
            a.PasswordHashed, 
            a.IsUser, 
            a.IsAccountDeleted,
            d.IsDonorDeleted,
            addr_country.Name AS Country,
            addr_city.Name AS City,
            addr_street.Name AS Street
        FROM 
            Donor d
        INNER JOIN Person p ON d.PersonID = p.PersonID
        INNER JOIN Account a ON d.PersonID = a.PersonID
        LEFT JOIN Address addr_street ON p.AddressID = addr_street.AddressID
        LEFT JOIN Address addr_city ON addr_street.ParentID = addr_city.AddressID
        LEFT JOIN Address addr_country ON addr_city.ParentID = addr_country.AddressID
    ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
//            $stmt = $this->db->prepare("
//            INSERT INTO Address
//            (City, Country, Street)
//            VALUES (?, ?, ?)
//        ");
            // Insert Country into Address table
            $stmt = $this->db->prepare("
            INSERT INTO Address 
            (Name, ParentID) 
            VALUES (?, ?)
        ");
            $stmt->execute([
                $data['country'], // Country Name
                NULL // ParentID for Country is NULL
            ]);
            $countryID = $this->db->lastInsertId();
            if (!$countryID) {
                throw new Exception("Failed to insert country into address.");
            }

            // Insert City into Address table
            $stmt->execute([
                $data['city'], // City Name
                $countryID // ParentID for City is Country ID
            ]);
            $cityID = $this->db->lastInsertId();
            if (!$cityID) {
                throw new Exception("Failed to insert city into address.");
            }

            // Insert Street into Address table
            $stmt->execute([
                $data['street'], // Street Name
                $cityID // ParentID for Street is City ID
            ]);
            $streetID = $this->db->lastInsertId();
            if (!$streetID) {
                throw new Exception("Failed to insert street into address.");
            }
            $addressID = $this->db->lastInsertId();
            if (!$addressID) {
                throw new Exception("Failed to insert address.");
            }

            // Insert into Person table
            $middleName = !empty($data['middleName']) ? $data['middleName'] : NULL;
            $stmt = $this->db->prepare("
            INSERT INTO Person 
            (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID) 
            VALUES (?, ?, ?, ?, ?, ?,  ?)
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
            (PersonID, Email, PasswordHashed, IsUser, IsAccountDeleted) 
            VALUES (?, ?, ?,  1, 0)
        ");
            $stmt->execute([
                $personID,
                $data['email'],
                $data['password']
            ]);

            // Insert into Donor table
            $stmt = $this->db->prepare("
            INSERT INTO Donor 
            (PersonID,  IsDonorDeleted) 
            VALUES (?, 0)
        ");
            $stmt->execute([
                $personID,
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
            p.Phone = ?, 
            a.Email = ?, 
            a.PasswordHashed = IF(? = '', a.PasswordHashed, ?), 
            a.IsUser = ?, 
            a.IsAccountDeleted = ?, 
            d.IsDonorDeleted = ?
        WHERE p.PersonID = ?
    ");

        try {
            // Execute the prepared statement
            $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $data['middleName'],
                $data['nationality'],
                $data['gender'],
                $data['phone'],
                $data['email'],
                $data['password'], // Placeholder for password logic
                $data['password'], // New password if provided
                $data['isUser'],
                $data['isAccountDeleted'],
                $data['isDonorDeleted'],
                $personID
            ]);

            return true; // Return true if update is successful
        } catch (\PDOException $e) {
            // Handle errors gracefully
            error_log("Update failed: " . $e->getMessage());
            return false; // Return false if update fails
        }
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
