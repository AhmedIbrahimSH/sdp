<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'charity_db';
    private $username = 'root';
    private $password = '';

    private  $port = 3307;
    private static $conn = null;

    public static function get_instance() {

        try {
            if(!isset(self::$conn)) {
                self::$conn = new PDO("mysql:host=" . (new self)->host . ";port=" . (new self)->port  . ";dbname=" . (new self)->db_name,
                    (new self)->username, (new self)->password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;

        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

    }
}

Database::get_instance();

