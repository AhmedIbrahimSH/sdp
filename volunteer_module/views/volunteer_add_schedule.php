<!DOCTYPE html>
<html>
<head>
    <title>Add Schedule</title>
</head>
<body>
<h1>Add Schedule to Volunteer</h1>

<form action="index.php?action=addSchedule&id=<?= htmlspecialchars($volunteerId) ?>" method="POST">
    <label>Date: <input type="date" name="schedule_date" required></label><br>
    <label>Hours: <input type="number" name="hours" min="1" required></label><br>
    <button type="submit">Add Schedule</button>
</form>

<a href="index.php?action=show&id=<?= htmlspecialchars($volunteerId) ?>">Back to Volunteer Details</a>
</body>
</html>
