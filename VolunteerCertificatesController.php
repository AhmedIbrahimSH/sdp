<?php
require_once 'VolunteerCertificates.php';

class VolunteerCertificatesController {
    private $volunteerCertificatesModel;

    public function __construct() {
        $this->volunteerCertificatesModel = new VolunteerCertificates();
    }

    // Add a new certificate to a specific task
    public function addCertificate($taskId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $certificateName = $_POST['certificate_name'];
            $dateAwarded = $_POST['date_awarded'];

            // Add the certificate to the task
            $this->volunteerCertificatesModel->addCertificate($taskId, $certificateName, $dateAwarded);

            // Redirect back to the task or volunteer details page
            header("Location: index.php?action=showTask&id=$taskId");
            exit;
        } else {
            // Ensure $taskId is available in the view by explicitly defining it here
            $taskId = htmlspecialchars($taskId); // Sanitize the taskId before passing it
            include 'views/volunteer_add_certificate.php';
        }
    }



    // Retrieve all certificates associated with a specific task
    public function getCertificates($taskId) {
        return $this->volunteerCertificatesModel->getCertificatesByTaskId($taskId);
    }

    // (Optional) Delete a certificate by ID
    public function deleteCertificate($certificateId, $taskId) {
        $this->volunteerCertificatesModel->deleteCertificate($certificateId);

        // Redirect back to the task details page
        header("Location: index.php?action=showTask&id=$taskId");
        exit;
    }
}
?>
