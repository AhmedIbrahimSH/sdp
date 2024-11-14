<?php
require_once 'VolunteerSkills.php';

class VolunteerSkillsController {
    private $volunteerSkillsModel;

    public function __construct() {
        $this->volunteerSkillsModel = new VolunteerSkills();
    }

    public function addSkill($volunteerId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $skill = $_POST['skill'];
            $this->volunteerSkillsModel->addSkill($volunteerId, $skill);
            header("Location: index.php?action=show&id=$volunteerId");
            exit;
        } else {
            include 'views/volunteer_add_skill.php';
        }
    }

    public function getSkills($volunteerId) {
        return $this->volunteerSkillsModel->getSkills($volunteerId);
    }
}
?>
