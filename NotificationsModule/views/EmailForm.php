<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>
    <h1>Send an Email</h1>
    <form method="POST" action="/email/sendEmail">
        <label for="recipient">Recipient Email:</label><br>
        <input type="email" id="recipient" name="recipient" required><br><br>

        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="body">Message:</label><br>
        <textarea id="body" name="body" required></textarea><br><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
