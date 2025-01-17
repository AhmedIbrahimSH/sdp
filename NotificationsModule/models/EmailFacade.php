<?php
namespace services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './vendor/phpmailer/phpmailer/src/SMTP.php' ;
require_once './vendor/phpmailer/phpmailer/src/Exception.php';

class EmailFacade{
    private $mailer;

    public function __construct()
    {
       // Load email configuration
       $config = require __DIR__ . '/NotificationsModule/config.php';

        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $config['smtp_host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $config['smtp_user'];
        $this->mailer->Password = $config['smtp_pass'];
        $this->mailer->SMTPSecure = $config['smtp_secure'];
        $this->mailer->Port = $config['smtp_port'];
        $this->mailer->setFrom($config['from_email'], $config['from_name']);
    }
    public function sendEmail($recipient, $subject, $body)
    {
    
        try {
            
            $this->mailer->addAddress($recipient);

            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send email
            $this->mailer->send();

            return ['status' => 'success', 'message' => 'Email sent successfully.'];
        } catch (Exception $e) {
            return ['status' => 'failure', 'message' =>  $this->mailer->ErrorInfo];
        }
    }

}