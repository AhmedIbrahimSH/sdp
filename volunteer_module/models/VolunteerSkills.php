<?php
namespace models;
use PDO;
require_once 'Database.php';

class VolunteerSkills
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addSkill($personId, $skillId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Volunteer_Skills (PersonID, skill_id)
            VALUES (:personId, :skillId)
        ");
        $stmt->execute([
            'personId' => $personId,
            'skillId' => $skillId
        ]);
    }

    public function getSkillsByVolunteer($personId)
    {
        $stmt = $this->db->prepare("
            SELECT s.id AS skill_id, s.skill
            FROM Volunteer_Skills vs
            JOIN Skill s ON vs.skill_id = s.id
            WHERE vs.PersonID = :personId 
        ");
        $stmt->execute(['personId' => $personId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeSkill($personId, $skillId)
    {
        $stmt = $this->db->prepare("
            UPDATE Volunteer_Skills
            SET IsVolunteerSkillDeleted = 1
            WHERE PersonID = :personId AND skill_id = :skillId
        ");
        $stmt->execute([
            'personId' => $personId,
            'skillId' => $skillId
        ]);
    }

    public function getAllSkills()
    {
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
