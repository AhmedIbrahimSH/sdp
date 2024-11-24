<?php

interface VolunteerObserver {
    public function update($eventType, $eventDetails, $person_id);
}
