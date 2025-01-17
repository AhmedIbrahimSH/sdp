<?php
namespace Controllers;


use services\EmailFacade;
// use Models\EmailModel;

require_once './EmailModel.php';
require_once './EmailFacade.php';

class EmailController
{
    private $emailModel;

    public function __construct($emailModel)
    {
        $this->emailModel = $emailModel;
    }

    public function showForm()
    {
        require_once './NotificationsModule/views/EmailForm.php';
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

        // Use the Facade class to send the email
        $emailFacade = new EmailFacade();
        $result = $emailFacade->sendEmail($recipient, $subject, $body);

        // Log email to the database
        $status = $result['status'] === 'success' ? 'success' : 'failure';
        $errorMessage = $result['status'] === 'failure' ? $result['message'] : null;

        $this->emailModel->logEmail('charitysdp5@gmail.com', $recipient, $subject, $body, $status, $errorMessage);

        echo json_encode($result);
    }
}
