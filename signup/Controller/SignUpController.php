<?php

class SignupController {
    public function index() {
        $error = null;
        require_once '../View/signup.php';
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $events = $_POST['events'] ?? [];

        if (empty($username) || empty($email) || empty($phone) || empty($events)) {
            $error = "All fields are required.";
            require_once '../View/signup.php';
        } else {
            header('Location: /thank-you');
        }
    }
}
