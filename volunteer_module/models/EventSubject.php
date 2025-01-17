<?php

namespace models;

interface EventSubject
{
    /**
     * Attach an observer to the subject.
     *
     * @param VolunteerObserver $observer The observer to attach.
     */
    public function attach(VolunteerObserver $observer);

    /**
     * Detach an observer from the subject.
     *
     * @param VolunteerObserver $observer The observer to detach.
     */
    public function detach(VolunteerObserver $observer);

    /**
     * Notify all attached observers about an event.
     *
     * @param string $eventType The type of event (e.g., 'fundraiser', 'workshop').
     * @param array $eventDetails Details about the event (e.g., name, date, description).
     */
    public function notify($eventType, $eventDetails);
}

?>
