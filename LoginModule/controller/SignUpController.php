<?php


require_once '../../EventModule/Model/database_connection.php';

class SignupController
{


    public static function register()
    {
        $conn = myDatabase::get_instance();
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = SignupController::hash($password);
        if (empty($username) || empty($email) || empty($phone) || empty($events))
            $error = "All fields are required.";
        $stmt = $conn->prepare("INSERT INTO account (Email, PasswordHashed, Type) VALUES (:email, :password, 'US')");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

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
