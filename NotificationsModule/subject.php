<?php


interface subject
{
    public function add(subscriber $observer);
    public function remove(subscriber $observer);
    public function notify($event_name, $type);

    public function notify_cancellation($event_name , $event_date , $type);
}