<?php


interface subject
{
    public function add(subscriber $observer);
    public function remove(subscriber $observer);
    public function notify($event_name, $event_date , $type);

    public function notify_cancellation($event_name , $event_date , $type);
}