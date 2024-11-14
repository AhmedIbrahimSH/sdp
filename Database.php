<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'red_crescent';
    private $username = 'root';
    private $password = 'admin';
    private $conn;
    private static $instance = null;

    // Private constructor to prevent creating multiple instances
    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    // Static method to get the single instance of Database
    public static function  getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to get the database connection
    public function getConnection() {
        return $this->conn;
    }
}
?>
