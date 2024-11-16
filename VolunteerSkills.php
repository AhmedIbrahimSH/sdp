<?php
require_once 'Database.php';

class VolunteerSkills {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a skill to the database for a specific volunteer
    public function addSkill($volunteerId, $skill) {
        $stmt = $this->db->prepare("
            INSERT INTO volunteer_skills (volunteer_id, skill)
            VALUES (:volunteer_id, :skill)
        ");
        $stmt->execute([
            'volunteer_id' => $volunteerId,
            'skill' => $skill
        ]);
    }

    // Retrieve all skills from the database for a specific volunteer
    public function getSkills($volunteerId) {
        $stmt = $this->db->prepare("
            SELECT skill
            FROM volunteer_skills
            WHERE volunteer_id = :volunteer_id
        ");
        $stmt->execute(['volunteer_id' => $volunteerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
