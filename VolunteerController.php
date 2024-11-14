<?php
require_once 'Volunteer.php';
require_once 'VolunteerSkillsController.php';
require_once 'VolunteerScheduleController.php';
require_once 'VolunteerTasksController.php';

class VolunteerController {
    private $volunteerModel;
    private $skillsController;
    private $scheduleController;
    private $tasksController;

    public function __construct() {
        $this->volunteerModel = new Volunteer();
        $this->skillsController = new VolunteerSkillsController();
        $this->scheduleController = new VolunteerScheduleController();
        $this->tasksController = new VolunteerTasksController();
    }

    public function index() {
        $volunteers = $this->volunteerModel->getAllVolunteers();
        include 'views/volunteer_list.php';
    }

    public function show($id) {
        $volunteer = $this->volunteerModel->getVolunteerById($id);

        // Retrieve related data
        $skills = $this->skillsController->getSkills($id);
        $schedule = $this->scheduleController->getSchedule($id);
        $tasks = $this->tasksController->getTasks($id);

        // Pass all data to the view
        include 'views/volunteer_detail.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create a Person record
            $personData = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $person_id = $this->volunteerModel->createPerson($personData);

            // Create a Volunteer record linked to the person_id
            $volunteerData = [
                'person_id' => $person_id,
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'joined_date' => $_POST['joined_date'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->volunteerModel->createVolunteer($volunteerData);

            header("Location: index.php?action=index");
            exit;
        } else {
            include 'views/volunteer_create.php';
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update Person data
            $personData = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $this->volunteerModel->updatePerson($id, $personData);

            // Update Volunteer data
            $volunteerData = [
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'joined_date' => $_POST['joined_date'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->volunteerModel->updateVolunteer($id, $volunteerData);

            header("Location: index.php?action=index");
            exit;
        } else {
            $volunteer = $this->volunteerModel->getVolunteerById($id);
            include 'views/volunteer_edit.php';
        }
    }

    public function delete($id) {
        $this->volunteerModel->deleteVolunteer($id);
        header("Location: index.php?action=index");
        exit;
    }
}
?>
