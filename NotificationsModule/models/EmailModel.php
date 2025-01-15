<?php

namespace Models;

require_once("Database.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


class EmailModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = Database::getConnection();
    }

    public function sendEmail($recipient, $subject, $body)
    {
        // Load email configuration
        $config = require __DIR__ . '/../../config/email_config.php';

        $mail = new PHPMailer(true);

        try {
            // PHPMailer settings
            $mail->isSMTP();
            $mail->Host = $config['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp_user'];
            $mail->Password = $config['smtp_pass'];
            $mail->SMTPSecure = $config['smtp_secure'];
            $mail->Port = $config['smtp_port'];

            // Sender and recipient
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($recipient);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Send email
            $mail->send();

            // Log success to database
            $this->logEmail($config['from_email'], $recipient, $subject, $body, 'success', null);

            return ['status' => 'success', 'message' => 'Email sent successfully.'];
        } catch (Exception $e) {
            // Log failure to database
            $this->logEmail($config['from_email'], $recipient, $subject, $body, 'failure', $mail->ErrorInfo);

            return ['status' => 'failure', 'message' => $mail->ErrorInfo];
        }
    }

    private function logEmail($sender, $recipient, $subject, $body, $status, $errorMessage = null)
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
