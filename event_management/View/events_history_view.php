<?php

require_once '../Model/load_events.php';


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

// Table headers
        echo "<tr style='background-color: #f2f2f2;'>
        <th style='border: 1px solid #ddd; padding: 8px;'>Title</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Location</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Date</th>
        <th style='border: 1px solid #ddd; padding: 8px;'>Price</th>
      </tr>";

// Table rows with data
        foreach ($this->event_object->getEvents() as $event) {
            echo "<tr>
            <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['title']) . "</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['location']) . "</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['date']) . "</td>
            <td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($event['price']) . "</td>
          </tr>";
        }

        echo "</table>";


    }


}

