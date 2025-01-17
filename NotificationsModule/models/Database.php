<?php
//
//namespace Models;
//
//use PDO;
//
//class Database
//{
//    private static $instance = null;
//    private $pdo;
//
//    private function __construct()
//    {
//        $this->pdo = new PDO("mysql:host=localhost;dbname=charity_db", "root", "");
//        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    }
//
//    public static function getInstance()
//    {
//        if (self::$instance === null) {
//            self::$instance = new Database();
//        }
//        return self::$instance;
//    }
//
//    public static function getConnection()
//    {
//        return self::getInstance()->pdo;
//    }
//}
