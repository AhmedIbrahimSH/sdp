<?php
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
        $key = array_search($volunteer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    // Notify all subscribers (volunteers) about the event
    public function notifyVolunteers() {
        foreach ($this->observers as $volunteer) {
            $volunteer->update($this);
        }
    }

    // Get event details (e.g., the event name)
    public function getEventDetails() {
        return "Event: " . $this->eventName;
    }
}
class WorkshopEvent extends Event {
    public function __construct($eventName = "Workshop") {
        parent::__construct($eventName);
    }
}

class FundraiserEvent extends Event {
    public function __construct($eventName = "Fundraiser") {
        parent::__construct($eventName);
    }
}

class ProgramEvent extends Event {
    public function __construct($eventName = "Program") {
        parent::__construct($eventName);
    }
}