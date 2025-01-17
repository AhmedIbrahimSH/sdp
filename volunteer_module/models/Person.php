<?php

namespace models;

require_once 'Database.php';

class Person
{
    protected $db;
    protected $personId;
    protected $firstName;
    protected $lastName;
    protected $middleName;
    protected $nationality;
    protected $gender;
    protected $personPhone;
    protected $addressId;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new person
    public function createPerson($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
            VALUES (:firstName, :lastName, :middleName, :nationality, :gender, :personPhone, :addressId)
        ");
        $stmt->execute([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'middleName' => $data['middleName'] ?? null,
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'personPhone' => $data['personPhone'],
            'addressId' => $data['addressId'] ?? null
        ]);
        $this->personId = $this->db->lastInsertId(); // Store the new PersonID
        return $this->personId;
    }

    // Retrieve a person by ID
    public function getPersonById($personId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM Person WHERE PersonID = :personId
        ");
        $stmt->execute(['personId' => $personId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->hydrate($data);
        }

        return $data;
    }

    // Update person details
    public function updatePerson($personId, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE Person
            SET FirstName = :firstName, LastName = :lastName, MiddleName = :middleName,
                Nationality = :nationality, Gender = :gender, PersonPhone = :personPhone, AddressID = :addressId
            WHERE PersonID = :personId
        ");
        $stmt->execute([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'middleName' => $data['middleName'] ?? null,
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'personPhone' => $data['personPhone'],
            'addressId' => $data['addressId'] ?? null,
            'personId' => $personId
        ]);
    }

    // Delete (soft delete) a person
    public function deletePerson($personId)
    {
        $stmt = $this->db->prepare("
            UPDATE Person SET isPersonDeleted = 1 WHERE PersonID = :personId
        ");
        $stmt->execute(['personId' => $personId]);
    }

    public function getPersonId()
    {
        return $this->personId;
    }

    // Hydrate object properties
    protected function hydrate($data)
    {
        $this->personId = $data['PersonID'];
        $this->firstName = $data['FirstName'];
        $this->lastName = $data['LastName'];
        $this->middleName = $data['MiddleName'];
        $this->nationality = $data['Nationality'];
        $this->gender = $data['Gender'];
        $this->personPhone = $data['PersonPhone'];
        $this->addressId = $data['AddressID'];
    }


    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getMiddleName()
    {
        return $this->middleName;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getPersonPhone()
    {
        return $this->personPhone;
    }

    public function getAddressId()
    {
        return $this->addressId;
    }
}

?>