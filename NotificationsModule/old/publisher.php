<?php


require 'subject.php';
require '../../sms_module/send_sms.php';
class publisher implements  subject
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

    public function notify($event_name, $type)
    {
        foreach (self::$subscribers as $subscriber) {
            if($type == $subscriber->getEventType()) {

//                smsSender::send_sms($event_name, "2024-10-04");
            }
        }
    }

    public function processForm() {
        if ($this->subscribe) {
            $this->notify();
        }
    }


    public function notify_cancellation($event_name, $event_date, $type)
    {
        foreach (self::$subscribers as $subscriber) {
            if($type == $subscriber->getEventType()) {
                $subscriber->sendMsg($event_name, $event_date);
            }
        }
    }
}