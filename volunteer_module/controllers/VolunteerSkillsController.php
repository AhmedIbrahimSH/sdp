<?php

namespace controllers;

use models\VolunteerSkills;

require_once  __DIR__  . '/../models/VolunteerSkills.php';
require_once  __DIR__  . '/../models/Volunteer.php';

class VolunteerSkillsController
{
    private $volunteerSkillsModel;

    public function __construct()
    {
        $this->volunteerSkillsModel = new VolunteerSkills();
    }

    // Display all skills for a specific volunteer
    public function index($personId)
    {
        $volunteerSkills = $this->volunteerSkillsModel->getSkillsByVolunteer($personId);
        $allSkills = $this->volunteerSkillsModel->getAllSkills(); // All available skills for selection
        include __DIR__  . '/../views/volunteer_skills_list.php'; // Pass data to the view
    }

    // Add a new skill to a volunteer
    public function addSkill($personId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $skillId = $_POST['skill_id']; // The skill to assign
            $this->volunteerSkillsModel->addSkill($personId, $skillId);

            header("Location: index.php?action=volunteer_skills&person_id=$personId");
            exit;
        } else {
            $allSkills = $this->volunteerSkillsModel->getAllSkills();
            include __DIR__  . '/../views/volunteer_add_skill.php'; // Show the skill assignment form
        }
    }

    // Remove a skill from a volunteer
    public function removeSkill($personId, $skillId)
    {
        $this->volunteerSkillsModel->removeSkill($personId, $skillId);

        header("Location: index.php?action=volunteer_skills&person_id=$personId");
        exit;
    }
}

?>
