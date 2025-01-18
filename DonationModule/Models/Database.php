<?php

namespace DonationModule\Models;
class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $this->pdo = new \PDO("mysql:host=localhost;dbname=charity_db", "root", "3082001");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    public static function getConnection()
    {
        if (!self::$instance) {
            self::$instance = new \PDO('mysql:host=localhost;dbname=charity_db', 'username', 'password');
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}