<?php


require 'subject.php';

class publisher implements  sub
{
    public static $subscribers = array();
    private $email;
    private $subscribe;
    public function __construct($formData) {
        // Initialize properties based on form data
//        $this->email = isset($formData['email']) ? $formData['email'] : null;
        $this->subscribe = isset($formData['subscribe']) && $formData['subscribe'] === 'yes';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->processForm();
        }
    }
    public function add(subscriber $observer)
    {
        self::$subscribers[] = $observer;
    }

    public function remove(subscriber $observer)
    {
        foreach (self::$subscribers as $key => $subscriber) {
            if ($subscriber === $observer) {
                unset(self::$subscribers[$key]);
            }
        }
    }

    public function notify($event_name)
    {
        foreach (self::$subscribers as $subscriber) {
            $subscriber->sendEmail($event_name);
        }
    }

    public function processForm() {
        // Check if "subscribe" checkbox was checked
        if ($this->subscribe) {
            // If checkbox is checked, send an email with form data
            $this->notify();
//            echo "Form processed and email sent!";
        } else {
//            echo "Form processed, but no email was sent (subscription not checked).";
        }
    }


}