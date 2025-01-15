<?php

namespace Controllers;

use Models\EmailModel;

class EmailController
{
    private $emailModel;

    public function __construct($db)
    {
        $this->emailModel = new EmailModel($db);
    }

    public function sendEmail()
    {
        // Get POST data
        $recipient = $_POST['recipient'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $body = $_POST['body'] ?? '';

        if (empty($recipient) || empty($subject) || empty($body)) {
            echo json_encode(['status' => 'failure', 'message' => 'All fields are required.']);
            return;
        }

        // Call the model to send the email
        $result = $this->emailModel->sendEmail($recipient, $subject, $body);

        echo json_encode($result);
    }
}
