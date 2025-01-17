<?php
require_once 'VolunteerCertificate.php';

class VolunteerCertificateController {
    private $volunteerCertificateModel;

    public function __construct() {
        $this->volunteerCertificateModel = new VolunteerCertificate();
    }

    // Display all certificates for a specific task
    public function indexByTask($taskId) {
        $certificates = $this->volunteerCertificateModel->getCertificatesByTask($taskId);
        include 'views/task_certificates_list.php'; // Pass data to the view
    }

    // Display all certificates for a specific volunteer
    public function indexByVolunteer($personId) {
        $certificates = $this->volunteerCertificateModel->getCertificatesByVolunteer($personId);

        include 'views/volunteer_detail.php';
        include 'views/volunteer_certificates_list.php'; // Pass data to the view
    }

    // Add a certificate to a task
    public function addCertificate($taskId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $certificateName = $_POST['certificate_name'];
            $dateAwarded = $_POST['date_awarded'];

            $this->volunteerCertificateModel->addCertificate($taskId, $certificateName, $dateAwarded);

            header("Location: index.php?action=task_certificates&task_id=$taskId");
            exit;
        } else {
            include 'views/add_certificate.php'; // Show the certificate creation form
        }
    }

    // Remove a certificate
    public function removeCertificate($certificateId, $taskId) {
        $this->volunteerCertificateModel->removeCertificate($certificateId);

        header("Location: index.php?action=task_certificates&task_id=$taskId");
        exit;
    }
}
?>
