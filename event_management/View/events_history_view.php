<?php

require_once '../Model/load_events.php';
require_once '../Controller/event_history.php';

class EventHistoryView{
    public $event_object;
    public function __construct(){
        $this->event_object = new Events();
        $this->index = 0;
    }

    public function show_table_history()
    {

        echo "<h2 style='text-align: center;'>Event History</h2>";

        echo "<table style='width: 100%; border-collapse: collapse; text-align: left;'>";

        echo "<tr style='background-color: #f2f2f2;'>
        <th style='border: 1px solid #ddd; padding: 8px;'>Title</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Location</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Date</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Type</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Price (EGP)</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Delete event</th>
      </tr>";

        foreach ($this->event_object->getEvents() as $event) {
            echo "<tr>
        <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['title']) . "</td>
        <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['location']) . "</td>
        <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['date']) . "</td>
         <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['type']) . "</td>
        <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['price']) . "</td>
        <td style='border: 1px solid #ddd; padding: 8px;'>
            <form method='POST'>
                <input type='hidden' name='title' value='" . htmlspecialchars($event['title']) . "'>
                <button type='submit' name='delete_event' 
                    style='background-color: red; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s;'>
                    Delete
                </button>
            </form>
        </td>
      </tr>";

        }

        echo "</table>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
            if (isset($_POST['title']) && !empty($_POST['title'])) {
                EventHistoryController::delete_event($_POST['title']);
                exit;
            } else {
                echo "Error: Title not set.";
            }
        }


    }


}

