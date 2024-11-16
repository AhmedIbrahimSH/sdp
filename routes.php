<?php

require 'Router.php';

$router = new Router();
$router->get('/calendar/events', 'CalendarController@getEvents');
