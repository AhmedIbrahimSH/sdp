<?php
abstract class Person
{
    protected $FirstName;
    protected $LastName;
    protected $MiddleName;
    protected $Nationality;
    protected $Gender;
    protected $PersonPhone;
    protected $AddressID;

    public function __construct($firstName, $lastName, $middleName = null, $nationality = null, $gender = null, $phone = null, $addressID = null)
    {
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->MiddleName = $middleName;
        $this->Nationality = $nationality;
        $this->Gender = $gender;
        $this->PersonPhone = $phone;
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
        return $this->PersonPhone;
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
