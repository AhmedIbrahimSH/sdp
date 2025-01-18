<?php


namespace controllers;

use models\CountryProxy;
use models\Volunteer;
use models\VolunteerCertificate;
use models\VolunteerSchedule;
use models\VolunteerSkills;
use models\VolunteerTasks;
use Exception;
use PDO;
use models\CountryService;
require_once __DIR__  . '/../models/VolunteerSkills.php';
require_once  __DIR__  . '/../models/VolunteerTasks.php';
require_once  __DIR__  . '/../models/VolunteerSchedule.php';
require_once  __DIR__  . '/../models/CountryProxy.php';
require_once  __DIR__  . '/../models/CountryService.php';
require_once  __DIR__  . '/VolunteerCertificateController.php';

class VolunteerController
{
    private $volunteerModel;
    private $volunteerSkillsModel;
    private $volunteerTasksModel;
    private $volunteerScheduleModel;
    private $volunteerCertificatesModel;
    private $countryService;
    public function showCreateForm()
    {

        // Use the CountryProxy to fetch nationalities
        $nationalities = $this->countryService->getAllCountries();

        // Pass the nationalities to the view
        require_once __DIR__  . '/../views/volunteer_create.php';
    }

    public function __construct()
    {
        $this->volunteerModel = new Volunteer();
        $this->volunteerSkillsModel = new VolunteerSkills();
        $this->volunteerTasksModel = new VolunteerTasks();
        $this->volunteerScheduleModel = new VolunteerSchedule();
        $this->volunteerCertificatesModel = new VolunteerCertificate();
        $this->countryService = new CountryProxy();
    }

    // Display all volunteers
    public function index()
    {
        $volunteers = $this->volunteerModel->getAllVolunteers();
        include  __DIR__  . '/../views/volunteer_list.php';
    }

    // Show details for a specific volunteer
    public function show($personId)
    {
        $volunteer = $this->volunteerModel->getVolunteerById($personId);
        $skills = $this->volunteerSkillsModel->getSkillsByVolunteer($personId);
        $tasks = $this->volunteerTasksModel->getTasksByVolunteer($personId);
        $schedule = $this->volunteerScheduleModel->getScheduleByVolunteer($personId);
        $certificates = $this->volunteerCertificatesModel->getCertificatesByVolunteer($personId);
        include  __DIR__  . '/../views/volunteer_detail.php';
    }

    // Add a new volunteer
    public function create()
    {
        // Use the CountryProxy to fetch nationalities
        $countryProxy = new CountryProxy();
        $nationalities = $countryProxy->getAllCountries();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
            $data = [
                'firstName' => $_POST['first_name'],
                'lastName' => $_POST['last_name'],
                'middleName' => $_POST['middle_name'] ?? null,
                'nationality' => $_POST['nationality'],
                'gender' => $_POST['gender'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'passwordHashed' => $_POST['hashed_password'], // Use the hashed password
                'type' => $_POST['type'] ?? 'Volunteer', // Add type field (default to 'Volunteer')
                'addressId' => $_POST['address_id'],
                'status' => $_POST['status']
            ];

            try {
                // Create the volunteer
                $personId = $this->volunteerModel->createVolunteer($data);

                // Redirect to the volunteer's profile page
                header("Location: index.php?action=show_volunteer&person_id=$personId");
                exit;
            } catch (Exception $e) {
                // Handle errors (e.g., display an error message)
                $error = "Error creating volunteer: " . $e->getMessage();
                echo $e;
                //include 'views/error.php';
            }
        } else {
            // Display the volunteer creation form
            include  __DIR__  . '/../views/volunteer_create.php';
        }
    }

    public function manageSubscriptions()
    {
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

            include  __DIR__  . '/../views/volunteer_subscriptions.php';
        }
    }

    // Edit an existing volunteer
    public function edit($personId)
    {

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
            include  __DIR__  . '/../views/volunteer_edit.php';
        }
    }

    // Delete a volunteer
    public function delete($personId)
    {
        $this->volunteerModel->deleteVolunteer($personId);
        header("Location: index.php?action=index");
        exit;
    }

    public function subscribeToEvent($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personId = $_POST['person_id']; // The volunteer's ID
            $eventType = $_POST['event_type']; // The event type they are subscribing to

            // Call the model to handle subscription
            $this->volunteerModel->subscribeToEvent($personId, $eventType);

            header("Location: index.php?action=show_event&id=$eventId");
            exit;
        } else {
            $volunteers = $this->volunteerModel->getAllVolunteers(); // Fetch all volunteers
            include  __DIR__  . '/../views/volunteer_subscribe_to_event.php';
        }
    }
}
