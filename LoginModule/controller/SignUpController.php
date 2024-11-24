<?php

require_once '../../EventModule/Model/database_connection.php';

class SignupController
{


    public static function register()
    {
        $conn = Database::get_instance();
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = SignupController::hash($password);
        if (empty($username) || empty($email) || empty($phone) || empty($events))
            $error = "All fields are required.";
        // Prepare the SQL statement with placeholders for the values
        $stmt = $conn->prepare("INSERT INTO account (Email, PasswordHashed, Type) VALUES (:email, :password, 'US')");

// Bind the values to the placeholders
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

// Execute the statement
        $stmt->execute();


    }

    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    SignupController::register();
}
