<?php
namespace services;
interface IEmail {
    public function sendEmail($recipient, $subject, $body);
}
