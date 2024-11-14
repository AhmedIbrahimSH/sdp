<?php
class VolunteerSkills {
    private $skills;

    public function __construct() {
        $this->skills = []; // Initialize as an empty array
    }

    public function addSkill($skill) {
        $this->skills[] = $skill;
    }

    public function getSkills() {
        return $this->skills;
    }
}
?>
