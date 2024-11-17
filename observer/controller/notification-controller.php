<?php
// namespace notify;
require_once __DIR__ ."../model/event-model.php";
require_once __DIR__ ."../model/volunteer-model.php";
class NotificationController {
    private $event;
    private $volunteers;

    public function __construct() {
        // Create an event and volunteer objects
        $this->event = new Event("Charity Run");
        $this->volunteers = [
            new Volunteer("John Doe"),
            new Volunteer("Jane Smith"),
        ];

        // Subscribe volunteers to the event
        foreach ($this->volunteers as $volunteer) {
            $volunteer->subscribeToEvent($this->event);
        }
    }

    // Notify all volunteers about the event
    public function notifyVolunteers() {
        $this->event->notifyVolunteers();
    }
}
