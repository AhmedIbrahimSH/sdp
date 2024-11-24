<?php

class Database
{
    public static $instance = null; // Hold the single instance
    private $connection;

    private $host = 'localhost';
    private $db_name = 'charity_db';
    private $username = 'root';
    private $password = '';

    // Private constructor prevents direct instantiation
    private function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
            die();
        }
    }

    // Static method to get the single instance of the class
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to get the PDO connection
    public function getConnection()
    {
        return $this->connection;
    }
}
