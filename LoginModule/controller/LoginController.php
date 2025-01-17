<?php

require_once '../view/login.html';
require_once '../model/get_user_creds.php';
class LoginController
{
    public function handleLogin()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $_SESSION['user'] = $username;
            // Check if 'user' is set in the session
            if (isset($_SESSION['user'])) {
                // Echo the session value for testing
                echo 'User session: ' . $_SESSION['user'];
            } else {
                // If session 'user' is not set, echo a message
                echo 'No user session found.';
            }
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
            header('Location: /sdp/user_interface_module/view/user_homepage.html');
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
