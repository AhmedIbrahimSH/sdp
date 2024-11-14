<?php
require_once 'Database.php';

class VolunteerCertificates {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a certificate to a specific task
    public function addCertificate($taskId, $certificateName, $dateAwarded) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteer_certificates (task_id, certificate_name, date_awarded)
            VALUES (:task_id, :certificate_name, :date_awarded)
        ");
        $stmt->execute([
            'task_id' => $taskId,
            'certificate_name' => $certificateName,
            'date_awarded' => $dateAwarded
        ]);
    }

    // Get all certificates for a specific task
    public function getCertificatesByTaskId($taskId) {
        $stmt = $this->db->prepare("
            SELECT * FROM volunteer_certificates
            WHERE task_id = :task_id
        ");
        $stmt->execute(['task_id' => $taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a certificate by ID
    public function deleteCertificate($certificateId) {
        $stmt = $this->db->prepare("
            DELETE FROM volunteer_certificates
            WHERE id = :id
        ");
        $stmt->execute(['id' => $certificateId]);
    }
}
?>
