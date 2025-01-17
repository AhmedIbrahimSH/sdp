<?php

use Models\EmailFacade;
use Models\Isms;

// require_once './EmailFacade.php';
// require_once './IEmail.php';
// require_once './Isms.php';

require_once __DIR__.'/../EmailFacade.php';
require_once __DIR__.'/../adapter/IEmail.php';
require_once __DIR__.'/../adapter/Isms.php';

class smsToEmailAdapter implements Isms {

    private $email;

    public function __construct(EmailFacade $email)
    {
        $this->email = $email;
    }

    public function send_sms($event_name,$event_date){
        $recipient = "malak.cheriff@gmail.com"; // hardcoded
        $subject = "Event Notification: {$event_name}";
        $message = "New event ({$event_name}) on {$event_date} 👀 Check it out now on our website";

        return $this->email->sendEmail($recipient, $subject, $message);
    }
    

}