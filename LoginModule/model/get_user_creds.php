<?php

require_once '../../EventModule/Model/database_connection.php';

class UserCredModel{
    private $conn;
    private $username;
    private $password;

    public function __construct(){
        $this->conn = Database::get_instance();
    }
    public function get_user_creds($Email, $password)
    {
        $query = "SELECT * FROM account WHERE Email = :Email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if ($password == $user['PasswordHashed']) {
                return $user;
            } else {
                return false;
            }
        }
        return false;
    }

}
