<?php

class Address {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch the hierarchical address data
    public function getAddressHierarchy($parentId = null) {
        $stmt = $this->db->prepare("
            SELECT AddressID, Name, ParentID 
            FROM Address 
            WHERE ParentID IS NULL OR ParentID = :parentId
        ");
        $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $stmt->execute();

        $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($addresses as &$address) {
            $address['children'] = $this->getAddressHierarchy($address['AddressID']);
        }

        return $addresses;
    }

    // Fetch a single address by ID
    public function getAddressById($addressId) {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM Address 
            WHERE AddressID = :addressId
        ");
        $stmt->bindParam(':addressId', $addressId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
