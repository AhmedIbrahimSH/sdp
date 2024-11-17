<?php
require_once "../model/event-model.php";
require_once  "../model/volunteer-model.php";
class NotificationController {
    private $events = [];
    public function __construct() {
        // Initialize events for different types
        $this->events['workshop'] = new WorkshopEvent();
        $this->events['fundraiser'] = new FundraiserEvent();
        $this->events['program'] = new ProgramEvent();
    }

    // Add a volunteer to a specific event type
    public function addVolunteer($name, $eventType) {
        if (!isset($this->events[$eventType])) {
            echo "Invalid event type: $eventType<br>";
            return;
        }

        $volunteer = new Volunteer($name);
        $volunteer->subscribeToEvent($this->events[$eventType]);
        echo "{$name} has been registered for the {$eventType} event.<br>";
    }

    // Notify all subscribers of a specific event type
    public function notifyVolunteers($eventType) {
        if (!isset($this->events[$eventType])) {
            echo "Invalid event type: $eventType<br>";
            return;
        }

        $this->events[$eventType]->notifyVolunteers();
    }
}
