<?php

namespace controllers;

use models\Event;
use models\Volunteer;

require_once  __DIR__  . '/../models/Event.php';

class EventsController
{
    private $eventModel;

    public function __construct()
    {
        $this->eventModel = new Event();
    }

    public function index()
    {
        $events = $this->eventModel->getAllEvents();
        include __DIR__  . '/../views/events_list.php';
    }
    public function show($eventId)
    {
        $event = $this->eventModel->getEventById($eventId);
        // Fetch assigned volunteers for the event
        $volunteers = $this->eventModel->getVolunteersByEventId($eventId);
        include __DIR__  . '/../views/event_detail.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventName = $_POST['event_name'];
            $eventDate = $_POST['event_date'];
            $description = $_POST['description'];

            $this->eventModel->createEvent($eventName, $eventDate, $description);

            header("Location: index.php?action=events");
            exit;
        } else {
            include __DIR__  . '/../views/event_create.php';
        }
    }

    public function edit($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventName = $_POST['event_name'];
            $eventDate = $_POST['event_date'];
            $description = $_POST['description'];

            $this->eventModel->updateEvent($eventId, $eventName, $eventDate, $description);

            header("Location: index.php?action=events");
            exit;
        } else {
            $event = $this->eventModel->getEventById($eventId);
            include __DIR__  . '/../views/event_edit.php';
        }
    }

    public function delete($eventId)
    {
        $this->eventModel->deleteEvent($eventId);
        header("Location: index.php?action=events");
        exit;
    }

    public function assignVolunteer($eventId)
    {
        $volunteerModel = new Volunteer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personId = $_POST['person_id'];
            $this->eventModel->assignVolunteerToEvent($personId, $eventId);

            header("Location: index.php?action=show_event&id=$eventId");
            exit;
        } else {
            $availableVolunteers = $volunteerModel->getAllVolunteers();

            include __DIR__  . '/../views/event_assign_volunteer.php';
        }
    }


    public function showVolunteerEvents($personId)
    {
        $events = $this->eventModel->getEventsByVolunteer($personId);
        include __DIR__  . '/../views/volunteer_events.php';
    }
}
