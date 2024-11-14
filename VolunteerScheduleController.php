<?php
require_once 'VolunteerSchedule.php';

class VolunteerScheduleController {
    private $volunteerScheduleModel;

    public function __construct() {
        $this->volunteerScheduleModel = new VolunteerSchedule();
    }

    // Add a new schedule entry for a volunteer
    public function addSchedule($volunteerId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scheduleDate = $_POST['schedule_date'];
            $hours = $_POST['hours'];

            // Add the schedule entry
            $this->volunteerScheduleModel->addScheduleEntry($volunteerId, $scheduleDate, $hours);

            // Redirect back to the volunteer's details page
            header("Location: index.php?action=show&id=$volunteerId");
            exit;
        } else {
            include 'views/volunteer_add_schedule.php';
        }
    }

    // Retrieve the schedule for a volunteer
    public function getSchedule($volunteerId) {
        return $this->volunteerScheduleModel->getScheduleByVolunteerId($volunteerId);
    }

}
?>
