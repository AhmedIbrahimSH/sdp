<?php
require_once 'Person.php';

class Account extends Person {
    private $email;
    private $passwordHashed;
    private $status;
    private $isUser;
    private $isAccountDeleted;

    public function __construct() {
        parent::__construct(); // Call the parent constructor
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new account
    public function createAccount($data) {
        $this->email = $data['email'];
        $this->passwordHashed = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->status = $data['status'] ?? 'Active';
        $this->isUser = $data['is_user'] ?? 1;

        $stmt = $this->db->prepare("
            INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser)
            VALUES (:person_id, :email, :password_hashed, :status, :is_user)
        ");
        $stmt->execute([
            'person_id' => $data['person_id'],
            'email' => $this->email,
            'password_hashed' => $this->passwordHashed,
            'status' => $this->status,
            'is_user' => $this->isUser
        ]);
    }

    // Retrieve account by PersonID
    public function getAccountByPersonId($personId) {
        $stmt = $this->db->prepare("
            SELECT * FROM Account WHERE PersonID = :person_id AND IsAccountDeleted = 0
        ");
        $stmt->execute(['person_id' => $personId]);
        $accountData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($accountData) {
            $this->email = $accountData['AccountEmail'];
            $this->passwordHashed = $accountData['AccountPasswordHashed'];
            $this->status = $accountData['Status'];
            $this->isUser = $accountData['IsUser'];
            $this->isAccountDeleted = $accountData['IsAccountDeleted'];
        }

        return $accountData;
    }

    // Authenticate account by email and password
    public function authenticate($email, $password) {
        $stmt = $this->db->prepare("
            SELECT * FROM Account WHERE AccountEmail = :email AND IsAccountDeleted = 0
        ");
        $stmt->execute(['email' => $email]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account && password_verify($password, $account['AccountPasswordHashed'])) {
            $this->email = $account['AccountEmail'];
            $this->passwordHashed = $account['AccountPasswordHashed'];
            $this->status = $account['Status'];
            $this->isUser = $account['IsUser'];
            $this->isAccountDeleted = $account['IsAccountDeleted'];
            return $account; // Authentication successful
        }

        return false; // Authentication failed
    }

    // Update account status
    public function updateStatus($personId, $status) {
        $this->status = $status;

        $stmt = $this->db->prepare("
            UPDATE Account
            SET Status = :status
            WHERE PersonID = :person_id
        ");
        $stmt->execute([
            'status' => $this->status,
            'person_id' => $personId
        ]);
    }

    // Delete an account (soft delete)
    public function deleteAccount($personId) {
        $this->isAccountDeleted = 1;

        $stmt = $this->db->prepare("
            UPDATE Account
            SET IsAccountDeleted = 1
            WHERE PersonID = :person_id
        ");
        $stmt->execute(['person_id' => $personId]);
    }

    // Getters for additional Account properties
    public function getEmail() {
        return $this->email;
    }

    public function getStatus() {
        return $this->status;
    }

    public function isUser() {
        return $this->isUser;
    }
}
?>
