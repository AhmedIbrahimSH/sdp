<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>
<h1>Add Task to Volunteer</h1>

<form action="index.php?action=addTask&id=<?= htmlspecialchars($volunteerId) ?>" method="POST">
    <label>Task Name: <input type="text" name="task_name" required></label><br>
    <label>Description: <textarea name="description"></textarea></label><br>
    <label>Due Date: <input type="date" name="due_date"></label><br>

    <h2>Optional Certificate</h2>
    <label>Certificate Name: <input type="text" name="certificate_name"></label><br>
    <label>Date Awarded: <input type="date" name="date_awarded"></label><br>

    <button type="submit">Add Task</button>
</form>

<a href="index.php?action=show&id=<?= htmlspecialchars($volunteerId) ?>">Back to Volunteer Details</a>
</body>
</html>
