<?php
require_once 'Volunteer.php';
require_once 'VolunteerSkills.php';
require_once 'VolunteerTasks.php';
require_once 'VolunteerSchedule.php';

class VolunteerController {
    private $volunteerModel;
    private $volunteerSkillsModel;
    private $volunteerTasksModel;
    private $volunteerScheduleModel;

    public function __construct() {
        $this->volunteerModel = new Volunteer();
        $this->volunteerSkillsModel = new VolunteerSkills();
        $this->volunteerTasksModel = new VolunteerTasks();
        $this->volunteerScheduleModel = new VolunteerSchedule();
    }

    // Display all volunteers
    public function index() {
        $volunteers = $this->volunteerModel->getAllVolunteers();
        include 'views/volunteer_list.php';
    }

    // Show details for a specific volunteer
    public function show($personId) {
        $volunteer = $this->volunteerModel->getVolunteerById($personId);
        $skills = $this->volunteerSkillsModel->getSkillsByVolunteer($personId);
        $tasks = $this->volunteerTasksModel->getTasksByVolunteer($personId);
        $schedule = $this->volunteerScheduleModel->getScheduleByVolunteer($personId);
        include 'views/volunteer_detail.php';
    }

    // Add a new volunteer
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'firstName' => $_POST['first_name'],
                'lastName' => $_POST['last_name'],
                'middleName' => $_POST['middle_name'] ?? null,
                'nationality' => $_POST['nationality'],
                'gender' => $_POST['gender'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'addressId' => $_POST['address_id'],
                'status' => $_POST['status']
            ];

            $personId = $this->volunteerModel->createVolunteer($data);

            header("Location: index.php?action=show_volunteer&person_id=$personId");
            exit;
        } else {
            include 'views/volunteer_create.php';
        }
    }

    // Edit an existing volunteer
    public function edit($personId) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'middleName' => $_POST['middleName'] ?? null,
                'nationality' => $_POST['nationality'],
                'gender' => $_POST['gender'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'addressId' => $_POST['addressId'],
                'status' => $_POST['status']
            ];

            $this->volunteerModel->updateVolunteer($personId, $data);
            header("Location: index.php?action=show_volunteer&person_id=$personId");
            exit;
        } else {
            $volunteer = $this->volunteerModel->getVolunteerById($personId);
            include 'views/volunteer_edit.php';
        }
    }

    // Delete a volunteer
    public function delete($personId) {
        $this->volunteerModel->deleteVolunteer($personId);
        header("Location: index.php?action=index");
        exit;
    }
}
?>
