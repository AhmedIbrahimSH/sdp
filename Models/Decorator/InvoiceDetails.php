<?php
require_once("Invoice.php");
class InvoiceDetails extends Invoice {
    private $detailID;
    private $itemDescription;
    private $quantity;
    private $unitPrice;
    private $lineTotal;
    private $donationID;

    /**
     * Constructor to initialize InvoiceDetails with parent database connection
     */
    public function __construct($lineTotal) {
        $this->lineTotal = $lineTotal;
        //parent::__construct($this); // Call parent constructor for database connection
    }

    // Getters and setters
    public function getDetailID() {
        return $this->detailID;
    }

    public function setDetailID($detailID) {
        $this->detailID = $detailID;
    }

    public function getItemDescription() {
        return $this->itemDescription;
    }

    public function setItemDescription($itemDescription) {
        $this->itemDescription = $itemDescription;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getUnitPrice() {
        return $this->unitPrice;
    }

    public function setUnitPrice($unitPrice) {
        $this->unitPrice = $unitPrice;
    }


    public function setLineTotal($lineTotal) {
        $this->lineTotal = $lineTotal;
    }

    public function getDonationID() {
        return $this->donationID;
    }

    public function setDonationID($donationID) {
        $this->donationID = $donationID;
    }


    public function generate() {
        // Include the Line Total in the string
        return "Line Total: {$this->lineTotal}";
    }

    public function getLineTotal() {
        return $this->lineTotal;
    }
    // Retrieve all details for a specific invoice
    public function getDetailsByInvoiceID($invoiceID) {
        $query = "SELECT * FROM InvoiceDetails WHERE InvoiceID = :invoiceID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":invoiceID", $invoiceID, PDO::PARAM_INT);
        $stmt->execute();

        $details = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $details[] = $row;
        }

        return $details;
    }

    // Create a new detail entry
    public function createDetail($data) {
        $query = "INSERT INTO InvoiceDetails (InvoiceID, ItemDescription, Quantity, UnitPrice, LineTotal, DonationID)
                  VALUES (:invoiceID, :itemDescription, :quantity, :unitPrice, :lineTotal, :donationID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":invoiceID", $data['InvoiceID'], PDO::PARAM_INT);
        $stmt->bindParam(":itemDescription", $data['ItemDescription'], PDO::PARAM_STR);
        $stmt->bindParam(":quantity", $data['Quantity'], PDO::PARAM_INT);
        $stmt->bindParam(":unitPrice", $data['UnitPrice'], PDO::PARAM_STR);
        $stmt->bindParam(":lineTotal", $data['LineTotal'], PDO::PARAM_STR);
        $stmt->bindParam(":donationID", $data['DonationID'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update a specific detail
    public function updateDetail($detailID, $data) {
        $query = "UPDATE InvoiceDetails
                  SET ItemDescription = :itemDescription, Quantity = :quantity, UnitPrice = :unitPrice, LineTotal = :lineTotal, DonationID = :donationID
                  WHERE DetailID = :detailID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":itemDescription", $data['ItemDescription'], PDO::PARAM_STR);
        $stmt->bindParam(":quantity", $data['Quantity'], PDO::PARAM_INT);
        $stmt->bindParam(":unitPrice", $data['UnitPrice'], PDO::PARAM_STR);
        $stmt->bindParam(":lineTotal", $data['LineTotal'], PDO::PARAM_STR);
        $stmt->bindParam(":donationID", $data['DonationID'], PDO::PARAM_INT);
        $stmt->bindParam(":detailID", $detailID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete a specific detail
    public function deleteDetail($detailID) {
        $query = "DELETE FROM InvoiceDetails WHERE DetailID = :detailID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":detailID", $detailID, PDO::PARAM_INT);

        return $stmt->execute();
    }





}
?>
