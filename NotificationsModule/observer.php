<?php


interface observer
{
    public function sendMsg($event_name, $msg = null);
}