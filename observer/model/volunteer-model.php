<?php
// namespace notify;
require_once __DIR__ ."observer.php";
require_once __DIR__ . "event-model.php";
class Volunteer implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getname():string{
        return $this->name;
    }

    // React to the event notification
    public function update(Event $event) {
        echo "{$this->name} has been notified about the event: {$event->getEventDetails()}<br>";
    }

    // Subscribe to an event
    public function subscribeToEvent(Event $event) {
        $event->subscribe($this);
    }

    // Unsubscribe from an event
    public function unsubscribeFromEvent(Event $event) {
        $event->unsubscribe($this);
    }
}