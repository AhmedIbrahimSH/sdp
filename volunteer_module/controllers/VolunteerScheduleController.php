<?php

namespace controllers;

use models\VolunteerSchedule;

require_once  __DIR__  . '/../models/VolunteerSchedule.php';

class VolunteerScheduleController
{
    private $volunteerScheduleModel;

    public function __construct()
    {
        $this->volunteerScheduleModel = new VolunteerSchedule();
    }

    public function index($personId)
    {
        $scheduleItems = $this->volunteerScheduleModel->getScheduleByVolunteer($personId);
        include __DIR__  . '/../views/volunteer_schedule_list.php';
    }

    public function addSchedule($personId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scheduleDate = $_POST['schedule_date'];
            $hours = $_POST['hours'];

            $this->volunteerScheduleModel->addScheduleItem($personId, $scheduleDate, $hours);

            header("Location: index.php?action=volunteer_schedule&person_id=$personId");
            exit;
        } else {
            include __DIR__  . '/../views/volunteer_add_schedule.php';
        }
    }

    public function editSchedule($scheduleId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scheduleDate = $_POST['schedule_date'];
            $hours = $_POST['hours'];

            $this->volunteerScheduleModel->updateScheduleItem($scheduleId, $scheduleDate, $hours);

            header("Location: index.php?action=volunteer_schedule&person_id=" . $_POST['person_id']);
            exit;
        } else {
            $scheduleItem = $this->volunteerScheduleModel->getScheduleByVolunteer($_GET['person_id']);
            include __DIR__  . '/../views/volunteer_edit_schedule.php';
        }
    }

    public function removeSchedule($scheduleId, $personId)
    {
        $this->volunteerScheduleModel->removeScheduleItem($scheduleId);

        header("Location: index.php?action=volunteer_schedule&person_id=$personId");
        exit;
    }
}

?>
