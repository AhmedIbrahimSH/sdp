<?php
abstract class Person
{
    public $FirstName;
    public $LastName;
    public $MiddleName;
    public $Nationality;
    public $Gender;
    public $Phone;
    public $AddressID;

    public function __construct($firstName, $lastName, $middleName = null, $nationality = null, $gender = null, $phone = null, $addressID = null)
    {
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->MiddleName = $middleName;
        $this->Nationality = $nationality;
        $this->Gender = $gender;
        $this->Phone = $phone;
        $this->AddressID = $addressID;
    }

    // Getter methods


    public function getFirstName()
    {
        return $this->FirstName;
    }

    public function getLastName()
    {
        return $this->LastName;
    }

    public function getMiddleName()
    {
        return $this->MiddleName;
    }

    public function getPhone()
    {
        return $this->Phone;
    }

    public function getNationality()
    {
        return $this->Nationality;
    }

    public function getGender()
    {
        return $this->Gender;
    }
}
