<?php

require_once '../view/login.html';
require_once '../model/get_user_creds.php';
class LoginController
{


    public function handleLogin()
    {
        session_start();
        $usermodel = new UserCredModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $user_id = $usermodel->get_user_id($username, $password);

            $_SESSION['user_mail'] = $username;
            $_SESSION['user_id'] = $user_id;

            if (isset($_SESSION['user'])) {
                file_put_contents("../../debug.log", $_SESSION['user_id'], FILE_APPEND);
            } else {
                file_put_contents("../../debug.log", "FOKAK", FILE_APPEND);
            }
            if (empty($username) || empty($password)) {
                $this->redirectWithError("Username or Password cannot be empty.");
                return;
            }

            if ($this->authenticate($username, $password) != false) {
                $_SESSION['username'] = $username;
                $this->redirect_user($this->authenticate($username, $password)['Type']);
                exit;
            } else {
                echo "Invalid username or password.";
                $this->redirectWithError("Invalid username or password.");
            }
        }
    }

    private function redirect_user($type)
    {
        $baseUrl = 'sdp/';
        if ($type == "EA") {
            header('Location:  /admin_interface_module/view/admin_homepage.html');
        } else if ($type == "BA") {
            header('Location: /BeneficiaryModule/index.php');
        } else if ($type == "US") {
            header('Location: /user_interface_module/view/user_homepage.html');
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
