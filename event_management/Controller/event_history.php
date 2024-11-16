<?php

require_once '../View/events_history_view.php';


class EventHistoryController
{
    public $event_history_view = null;

    public function __construct()
    {
        $this->event_history_view = new EventHistoryView();
        $this->event_history_view->show_table_history();
    }

    public function delete_event($event_title){

    }




}

// Check if "Show Event History" button was clicked
$dp = new EventHistoryController();



