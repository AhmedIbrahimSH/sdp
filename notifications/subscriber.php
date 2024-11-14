<?php

require_once 'observer.php';
require_once 'publisher.php';
class subscriber implements observer
{
    public $publisher;

    public function __construct()
    {
        $this->publisher = new publisher($_POST);
        $this->publisher->add($this);
    }
    public function sendEmail() {
        $msg_sbg = "Subscription Confirmation";
        $message = "Thank you for subscribing to notifications!";
        $headers = "From: your-email@example.com\r\n";
        $headers .= "Reply-To: your-email@example.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
//        echo "ok ok ";
        // Send email

    }
}