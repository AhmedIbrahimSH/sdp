<?php
// Retrieve person_id from GET request
$personId = isset($_GET['person_id']) && is_numeric($_GET['person_id']) ? intval($_GET['person_id']) : null;

// Check if person_id is valid
if (!$personId) {
    echo "<h1>Error: Invalid or missing person ID.</h1>";
    exit; // Stop script execution if person_id is not valid
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 15px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Add Schedule to Volunteer</h1>

    <form action="index.php?action=add_schedule&person_id=<?= htmlspecialchars($personId) ?>" method="POST">
        <label for="schedule_date">Date:</label>
        <input type="date" name="schedule_date" id="schedule_date" required>

        <label for="hours">Hours:</label>
        <input type="number" name="hours" id="hours" min="1" required>

        <button type="submit">Add Schedule</button>
    </form>

    <a href="index.php?action=show&id=<?= htmlspecialchars($personId) ?>">Back to Volunteer Details</a>
</div>
</body>
</html>
