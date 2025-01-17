<?php

namespace models;
interface VolunteerObserver
{
    public function update($eventType, $eventDetails, $person_id);
}
