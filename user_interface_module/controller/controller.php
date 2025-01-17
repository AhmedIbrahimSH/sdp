<?php
// Start the session
session_start();

// Store a value in the session
$_SESSION['user_id'] = 123;  // Example: storing user ID

// Optionally, you can store multiple values
$_SESSION['username'] = 'JohnDoe';

// Output to confirm the values are stored
echo "User ID: " . $_SESSION['user_id'] . "<br>";
echo "Username: " . $_SESSION['username'] . "<br>";
?>
