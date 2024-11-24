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

    public static function delete_event($event_title){
        $conn = Database::get_instance();
        $query = "DELETE FROM events WHERE Title = :title";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $event_title);
        $stmt->execute();
    }

}



$event_history_controller = new EventHistoryController();



