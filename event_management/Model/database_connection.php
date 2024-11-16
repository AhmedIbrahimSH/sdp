<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'event_management';
    private $username = 'root';
    private $password = '';
    private static $conn = null;

    public static function get_instance() {

        try {
            if(!isset(self::$conn)) {
                self::$conn = new PDO("mysql:host=" . (new self)->host . ";dbname=" . (new self)->db_name,
                    (new self)->username, (new self)->password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return self::$conn;

            } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

    }
}

