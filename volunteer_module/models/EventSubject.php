<?php

namespace models;

interface EventSubject
{
    public function attach(VolunteerObserver $observer);


    public function detach(VolunteerObserver $observer);


    public function notify($eventType, $eventDetails);
}

?>
