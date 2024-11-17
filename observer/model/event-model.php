<?php
// namespace notify;
require_once "volunteer-model.php";
class Event {
    private $observers = [];  // List of subscribers (volunteers)
    private $eventName;


    public function __construct($eventName) {
        $this->eventName = $eventName;
    }

    // Subscribe a volunteer to the event
    public function subscribe(Volunteer $volunteer) {
        $this->observers[] = $volunteer;
    }

    // Unsubscribe a volunteer from the event
    public function unsubscribe(Volunteer $volunteer) {
        $this->observers = array_filter($this->observers, function($observer) use ($volunteer) {
            return $observer !== $volunteer;
        });
    }

    // Notify all subscribers (volunteers) about the event
    public function notifyVolunteers() {
        foreach ($this->observers as $volunteer) {
            $volunteer->update($this);
        }
    }

    // Get event details (e.g., the event name)
    public function getEventDetails() {
        return $this->eventName;
    }
}
