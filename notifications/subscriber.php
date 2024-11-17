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

    public function getObserverName()
    {
        return $this->subscriber_name;
    }

    public function sendMsg($event_name, $msg = null) {
        $logFile = '../../notifications.log';
        file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $msg . PHP_EOL, FILE_APPEND);

    }


}