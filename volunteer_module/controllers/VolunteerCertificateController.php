<?php
namespace controllers;

use models\VolunteerCertificate;

require_once  __DIR__  . '/../models/VolunteerCertificate.php';

class VolunteerCertificateController
{
    private $volunteerCertificateModel;

    public function __construct()
    {
        $this->volunteerCertificateModel = new VolunteerCertificate();
    }

    // Display all certificates for a specific task
    public function indexByTask($taskId)
    {
        $certificates = $this->volunteerCertificateModel->getCertificatesByTask($taskId);
        include __DIR__  . '/../views/task_certificates_list.php'; // Pass data to the view
    }

    // Display all certificates for a specific volunteer
    public function indexByVolunteer($personId)
    {
        $certificates = $this->volunteerCertificateModel->getCertificatesByVolunteer($personId);

        include __DIR__  . '/../views/volunteer_detail.php';
        include __DIR__  . '/../views/volunteer_certificates_list.php'; // Pass data to the view
    }

    // Add a certificate to a task
    public function addCertificate($personId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $certificateName = $_POST['certificate_name'];
            $dateAwarded = $_POST['date_awarded'];

            $this->volunteerCertificateModel->addCertificate($personId, $certificateName, $dateAwarded);

            header("Location: index.php?action=volunteer_certificates&person_id=$personId");
            exit;
        } else {
            include __DIR__  . '/../views/add_certificate.php'; // Show the certificate creation form
        }
    }

    // Remove a certificate
    public function removeCertificate($certificateId, $taskId)
    {
        $this->volunteerCertificateModel->removeCertificate($certificateId);

        header("Location: index.php?action=task_certificates&task_id=$taskId");
        exit;
    }
}

?>
