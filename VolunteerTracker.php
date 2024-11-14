<?php
require_once 'VolunteerSkills.php';
require_once 'VolunteerSchedule.php';
require_once 'VolunteerTasks.php';

class VolunteerTracker {
    private $skills;
    private $schedule;
    private $tasks;

    public function __construct() {
        $this->skills = new VolunteerSkills();
        $this->schedule = new VolunteerSchedule();
        $this->tasks = []; // Initialize as an empty array
    }

    // Methods to interact with VolunteerSkills
    public function addSkill($skill) {
        $this->skills->addSkill($skill);
    }

    public function getSkills() {
        return $this->skills->getSkills();
    }

    // Methods to interact with VolunteerSchedule
    public function addScheduleItem($date, $hours) {
        $this->schedule->addScheduleItem($date, $hours);
    }

    public function getSchedule() {
        return $this->schedule->getSchedule();
    }

    // Methods to manage VolunteerTasks
    public function addTask(VolunteerTasks $task) {
        $this->tasks[] = $task;
    }

    public function getTasks() {
        return $this->tasks;
    }
}
?>
