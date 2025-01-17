<?php
require_once 'Database.php';

class VolunteerSkills {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a skill for a volunteer
    public function addSkill($personId, $skillId) {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Skills (person_id, skill_id)
            VALUES (:personId, :skillId)
        ");
        $stmt->execute([
            'personId' => $personId,
            'skillId' => $skillId
        ]);
    }

    // Get all skills for a specific volunteer
    public function getSkillsByVolunteer($personId) {
        $stmt = $this->db->prepare("
            SELECT s.id AS skill_id, s.skill
            FROM Volunteer_Skills vs
            JOIN Skill s ON vs.skill_id = s.id
            WHERE vs.PersonID = :personId 
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Remove a skill for a specific volunteer (soft delete)
    public function removeSkill($personId, $skillId) {
        $stmt = $this->db->prepare("
            UPDATE Volunteer_Skills
            SET IsVolunteerSkillDeleted = 1
            WHERE person_id = :personId AND skill_id = :skillId
        ");
        $stmt->execute([
            'personId' => $personId,
            'skillId' => $skillId
        ]);
    }

    // Get all available skills from the Skill table
    public function getAllSkills() {
        $stmt = $this->db->prepare("
            SELECT id, skill
            FROM Skill
            ORDER BY skill ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
