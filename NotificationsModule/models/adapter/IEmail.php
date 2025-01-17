<?php
namespace Models;
interface IEmail {
    public function sendEmail($recipient, $subject, $body);
}
