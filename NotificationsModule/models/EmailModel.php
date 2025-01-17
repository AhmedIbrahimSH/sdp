<?php
namespace Models;

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require_once './Database.php';
// require_once './NotificationsModule/config.php' ;
// require_once './vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require_once './vendor/phpmailer/phpmailer/src/SMTP.php' ;
// require_once './vendor/phpmailer/phpmailer/src/Exception.php';

require_once __DIR__ .'/../models/Database.php';
require_once __DIR__ .'/../config.php';
require_once __DIR__ .'/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ .'/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ .'/../../vendor/phpmailer/phpmailer/src/Exception.php';

class EmailModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = Database::getConnection();
    }

    public function logEmail($sender, $recipient, $subject, $body, $status, $errorMessage = null)
    {
        $query = "INSERT INTO EmailLogs (sender_email, recipient_email, subject, body, status, error_message)
                  VALUES (:sender_email, :recipient_email, :subject, :body, :status, :error_message)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':sender_email' => $sender,
            ':recipient_email' => $recipient,
            ':subject' => $subject,
            ':body' => $body,
            ':status' => $status,
            ':error_message' => $errorMessage,
        ]);
    }
  
   
}
