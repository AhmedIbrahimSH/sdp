<?php
// Start the session
session_start();

$_SESSION['user_id'] = 123;

$_SESSION['username'] = 'JohnDoe';

echo "User ID: " . $_SESSION['user_id'] . "<br>";
echo "Username: " . $_SESSION['username'] . "<br>";
?>
