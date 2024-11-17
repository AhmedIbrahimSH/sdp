<?php
// namespace notify;
require_once __DIR__ ."volunteer-model.php";
require_once __DIR__ ."event-model.php";
class Notification {
    public function sendNotification(Volunteer $volunteer, Event $event) {
        // For simplicity, we'll just echo the notification
        echo "Sending notification to {$volunteer->getName()} about event: {$event->getEventDetails()}<br>";
    }
}
