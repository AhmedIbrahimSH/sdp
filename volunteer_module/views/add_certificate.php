<!DOCTYPE html>
<html>
<head>
    <title>Add Certificate</title>
</head>
<body>
<h1>Add Certificate to Task</h1>

<form action="index.php?action=add_certificate&task_id=<?= htmlspecialchars($taskId); ?>" method="POST">
    <label for="certificate_name">Certificate Name:</label>
    <input type="text" name="certificate_name" id="certificate_name" required><br>

    <label for="date_awarded">Date Awarded:</label>
    <input type="date" name="date_awarded" id="date_awarded" required><br>

    <button type="submit">Add Certificate</button>
</form>

<a href="index.php?action=task_certificates&task_id=<?= htmlspecialchars($taskId); ?>">Back to Certificates</a>
</body>
</html>
