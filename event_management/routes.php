<?php

require 'Router.php';

$router = new Router();
// routes.php
$router->get('/calendar/events', 'CalendarController@getEvents');
