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

    // Display all events
    public function index()
    {
        $events = $this->eventModel->getAllEvents();
        include __DIR__  . '/../views/events_list.php'; // Pass events to the view
    }

    // Show a single event by ID
    public function show($eventId)
    {
        $event = $this->eventModel->getEventById($eventId);
        // Fetch assigned volunteers for the event
        $volunteers = $this->eventModel->getVolunteersByEventId($eventId);
        include __DIR__  . '/../views/event_detail.php'; // Pass event to the view
    }

    // Create a new event
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventName = $_POST['event_name'];
            $eventDate = $_POST['event_date'];
            $description = $_POST['description'];

            $this->eventModel->createEvent($eventName, $eventDate, $description);

            header("Location: index.php?action=events"); // Redirect to events index
            exit;
        } else {
            include __DIR__  . '/../views/event_create.php'; // Show the event creation form
        }
    }

    // Edit an existing event
    public function edit($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventName = $_POST['event_name'];
            $eventDate = $_POST['event_date'];
            $description = $_POST['description'];

            $this->eventModel->updateEvent($eventId, $eventName, $eventDate, $description);

            header("Location: index.php?action=events"); // Redirect to events index
            exit;
        } else {
            $event = $this->eventModel->getEventById($eventId);
            include __DIR__  . '/../views/event_edit.php'; // Show the event edit form
        }
    }

    // Delete an event
    public function delete($eventId)
    {
        $this->eventModel->deleteEvent($eventId);
        header("Location: index.php?action=events"); // Redirect to events index
        exit;
    }

    // Assign a volunteer to an event
    public function assignVolunteer($eventId)
    {
        $volunteerModel = new Volunteer(); // Instantiate Volunteer model to fetch volunteers

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personId = $_POST['person_id']; // The ID of the volunteer to assign
            $this->eventModel->assignVolunteerToEvent($personId, $eventId);

            header("Location: index.php?action=show_event&id=$eventId"); // Redirect to the event detail page
            exit;
        } else {
            // Fetch all volunteers
            $availableVolunteers = $volunteerModel->getAllVolunteers();

            // Pass the event ID and available volunteers to the view
            include __DIR__  . '/../views/event_assign_volunteer.php';
        }
    }


    // Show all events for a specific volunteer
    public function showVolunteerEvents($personId)
    {
        $events = $this->eventModel->getEventsByVolunteer($personId);
        include __DIR__  . '/../views/volunteer_events.php'; // Pass events to the view
    }
}
