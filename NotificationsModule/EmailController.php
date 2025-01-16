<?php

namespace Controllers;
use Models\EmailModel;
// require_once '../models/EmailModel.php';
require_once './EmailModel.php';
class EmailController
{
    private $emailModel;

    public function __construct($emailModel)
    {
        $this->emailModel = $emailModel;
    }

    public function showForm()
    {
        require_once __DIR__ . '/NotificationsModule/views/EmailForm.php';
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
