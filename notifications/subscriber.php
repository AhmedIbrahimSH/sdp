<?php

require_once 'observer.php';
require_once 'publisher.php';

class subscriber implements observer
{
    private $publisher;
    private $subscriber_name;
    private $subscriber_type;

    public function __construct($subscriber_name, $subscriber_type)
    {
        $this->subscriber_name = $subscriber_name;
        $this->subscriber_type = $subscriber_type;
        $this->publisher = new publisher($_POST);
        $this->publisher->add($this);
    }

    public function getEventType() {
        return $this->subscriber_type;
    }

    public function sendEmail($event_name) {
        $message = "Hey $this->subscriber_name a new event $event_name is added ";
        $logFile = '../../notifications.log';
        file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);

    }
}