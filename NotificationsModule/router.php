<?php
use Controllers\EmailController

$router->post('/email/sendEmail', [EmailController::class, 'sendEmail']);
