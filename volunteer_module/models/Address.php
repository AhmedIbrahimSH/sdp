<?php
namespace models;

require_once 'Database.php';

class Address
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new address
    public function createAddress($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Address (Name, ParentID)
            VALUES (:name, :parent_id)
        ");
        $stmt->execute([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null
        ]);
        return $this->db->lastInsertId(); // Return the new AddressID
    }

    // Retrieve an address by ID
    public function getAddressById($addressId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM Address WHERE AddressID = :address_id
        ");
        $stmt->execute(['address_id' => $addressId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retrieve all child addresses for a parent ID
    public function getChildAddresses($parentId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM Address WHERE ParentID = :parent_id
        ");
        $stmt->execute(['parent_id' => $parentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an address
    public function updateAddress($addressId, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE Address
            SET Name = :name, ParentID = :parent_id
            WHERE AddressID = :address_id
        ");
        $stmt->execute([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'address_id' => $addressId
        ]);
    }

    // Delete an address
    public function deleteAddress($addressId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM Address WHERE AddressID = :address_id
        ");
        $stmt->execute(['address_id' => $addressId]);
    }
}

?>
