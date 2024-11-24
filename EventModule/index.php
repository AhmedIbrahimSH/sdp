<?php

require_once 'Model/database_connection.php';
require_once 'Model/load_events.php';
require_once 'Controller/add_event.php';
require_once 'Controller/event_history.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'add_event':
        include 'Controller/add_event.php';
        break;

    case 'event_history':
        include 'Controller/event_history.php';
        break;

    case 'home':
    default:
        include 'View/new_event_view.html';
        break;
}
