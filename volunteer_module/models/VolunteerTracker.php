<?php


namespace models;
require_once 'VolunteerSkills.php';
require_once 'VolunteerSchedule.php';
require_once 'VolunteerTasks.php';
require_once 'VolunteerEvents.php';

class VolunteerTracker {
    private $personId;
    private $skills;
    private $schedule;
    private $tasks;
    private $events; // Aggregated VolunteerEvents

    public function __construct($personId) {
        $this->personId = $personId;
        $this->skills = new VolunteerSkills();
        $this->schedule = new VolunteerSchedule();
        $this->tasks = new VolunteerTasks();
        $this->events = new VolunteerEvents(); // Initialize events
    }

    // Methods to interact with VolunteerSkills
    public function addSkill($skill) {
        $this->skills->addSkill($this->personId, $skill);
    }

    public function getSkills() {
        return $this->skills->getSkillsByPersonId($this->personId);
    }

    // Methods to interact with VolunteerSchedule
    public function addScheduleItem($date, $hours) {
        $this->schedule->addScheduleItem($this->personId, $date, $hours);
    }

    public function getSchedule() {
        return $this->schedule->getScheduleByPersonId($this->personId);
    }

    // Methods to manage VolunteerTasks
    public function addTask($taskName, $description, $dueDate) {
        $this->tasks->addTask($this->personId, $taskName, $description, $dueDate);
    }

    public function getTasks() {
        return $this->tasks->getTasksByPersonId($this->personId);
    }

    // Methods to manage VolunteerEvents
    public function addEvent($eventName, $eventDate, $description) {
        $this->events->addEvent($this->personId, $eventName, $eventDate, $description);
    }

    public function getEvents() {
        return $this->events->getEventsByPersonId($this->personId);
    }
}
?>