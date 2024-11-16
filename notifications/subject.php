<?php


interface sub
{
    public function add(subscriber $observer);
    public function remove(subscriber $observer);
    public function notify($event_name, $type);
}