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
    public function manageSubscriptions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personId = $_POST['person_id'];
            $subscriptions = $_POST['subscriptions'] ?? [];

            // Remove all current subscriptions
            $stmt = $this->db->prepare("DELETE FROM Volunteer_Subscriptions WHERE person_id = :person_id");
            $stmt->execute(['person_id' => $personId]);

            // Add new subscriptions
            foreach ($subscriptions as $type) {
                $stmt = $this->db->prepare("
                    INSERT INTO Volunteer_Subscriptions (person_id, event_type)
                    VALUES (:person_id, :event_type)
                ");
                $stmt->execute(['person_id' => $personId, 'event_type' => $type]);
            }

            header("Location: index.php?action=volunteer_subscriptions");
        } else {
            $personId = $_GET['person_id'];
            $stmt = $this->db->prepare("SELECT event_type FROM Volunteer_Subscriptions WHERE person_id = :person_id");
            $stmt->execute(['person_id' => $personId]);
            $currentSubscriptions = $stmt->fetchAll(PDO::FETCH_COLUMN);

            include 'views/volunteer_subscriptions.php';
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
    public function subscribeToEvent($eventId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personId = $_POST['person_id']; // The volunteer's ID
            $eventType = $_POST['event_type']; // The event type they are subscribing to

            // Call the model to handle subscription
            $this->volunteerModel->subscribeToEvent($personId, $eventType);

            header("Location: index.php?action=show_event&id=$eventId");
            exit;
        } else {
            $volunteers = $this->volunteerModel->getAllVolunteers(); // Fetch all volunteers
            include 'views/volunteer_subscribe_to_event.php';
        }
    }
}
?>
