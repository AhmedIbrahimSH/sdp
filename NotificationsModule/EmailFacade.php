<!-- 
namespace services;

require_once './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './vendor/phpmailer/phpmailer/src/SMTP.php' ;
require_once './vendor/phpmailer/phpmailer/src/Exception.php';

class EmailFacade{
    public function sendEmail($recipient, $subject, $body)
    {
        // Load email configuration
        $config = require __DIR__ . '/NotificationsModule/config.php';

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

            return ['status' => 'success', 'message' => 'Email sent successfully.'];
        } catch (Exception $e) {
            return ['status' => 'failure', 'message' => $mail->ErrorInfo];
        }
    }

} -->