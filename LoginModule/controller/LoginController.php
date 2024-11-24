<?php

require_once '../View/login.html';
require_once '../Model/get_user_creds.php';
class LoginController
{
    public function handleLogin()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $this->redirectWithError("Username or Password cannot be empty.");
                return;
            }

            if ($this->authenticate($username, $password ) != false) {
                $_SESSION['username'] = $username;
                $this->redirect_user($this->authenticate($username, $password)['Type']);
                exit;
            } else {
                echo "Invalid username or password.";
                $this->redirectWithError("Invalid username or password.");
            }
        }
    }

    private function redirect_user($type){
        $baseUrl = 'sdp/';
        if($type == "EA"){
            header('Location:' . $baseUrl . '../../EventModule/View/new_event_view.html');
        }else if($type == "BA"){
            header('Location: /fundraiser');
        }else if($type == "US"){
            header('Location: /workshop');
        }
    }

    private function authenticate($username, $password)
    {
        $checker = new UserCredModel();
        $user = $checker->get_user_creds($username, $password);
        return $user;
    }

    private function redirectWithError($error)
    {
        $_SESSION['error'] = $error;
        print_r($_SESSION);
        header('Location: /errorhappened');
        exit;
    }
}

$controller = new LoginController();
$controller->handleLogin();
