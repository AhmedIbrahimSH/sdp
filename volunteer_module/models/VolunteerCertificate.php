<?php
namespace models;
use PDO;
require_once 'Database.php';

class VolunteerCertificate
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a certificate for a task
    public function addCertificate($personId, $certificateName, $dateAwarded)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Certificates (PersonID, certificate_name, date_awarded)
            VALUES (:PersonID, :certificateName, :dateAwarded)
        ");
        $stmt->execute([
            'PersonID' => $personId,
            'certificateName' => $certificateName,
            'dateAwarded' => $dateAwarded
        ]);
    }

    // Get certificates for a specific task
    public function getCertificatesByTask($taskId)
    {
        $stmt = $this->db->prepare("
            SELECT id AS certificate_id, certificate_name, date_awarded
            FROM Volunteer_Certificates
            WHERE task_id = :taskId
        ");
        $stmt->execute(['taskId' => $taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get certificates for a specific volunteer
    public function getCertificatesByVolunteer($personId)
    {
        $stmt = $this->db->prepare("
            SELECT vc.id AS certificate_id, vc.certificate_name, vc.date_awarded
            FROM Volunteer_Certificates vc
            WHERE vc.PersonID = :personId
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Remove a certificate by its ID
    public function removeCertificate($certificateId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM Volunteer_Certificates
            WHERE id = :certificateId
        ");
        $stmt->execute(['certificateId' => $certificateId]);
    }
}

?>
