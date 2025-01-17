<?php
namespace services;
interface IEmail {
    public function send_sms($event_name,$event_date);
}
