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
