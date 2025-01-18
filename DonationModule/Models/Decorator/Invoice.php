<?php

namespace DonationModule\Models\Decorator;
use DoModels\Decorator\Exception;

require_once("DonationModule/Models/Database.php");

abstract class Invoice
{
    protected $db;
    private $invoiceID;
    private $invoiceDate;

    private $invoiceAmount;


    private $donorID;

    /**
     * @return mixed
     */
    public function getInvoiceID()
    {
        return $this->invoiceID;
    }

    /**
     * @param mixed $invoiceID
     */
    public function setInvoiceID($invoiceID)
    {
        $this->invoiceID = $invoiceID;
    }

// Create a new invoice

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    abstract public function generate();
    // Retrieve all invoices
    // Common methods shared across subclasses
    public function getAll()
    {
        $query = "SELECT * FROM Invoice";
        $result = $this->db->query($query);

        $invoices = [];
        while ($row = $result->fetch_assoc()) {
            $invoices[] = $row;
        }

        return $invoices;
    }

    // Utility method to validate invoice data
    protected function validateData($data)
    {
        // Example: Check if required fields are present
        if (!isset($data['InvoiceDate']) || !isset($data['TotalAmount']) || !isset($data['PersonID'])) {
            throw new Exception("Missing required fields.");
        }

        // Additional validation logic can go here
        return true;
    }
}