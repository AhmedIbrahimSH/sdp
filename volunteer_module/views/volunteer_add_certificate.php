<!DOCTYPE html>
<html>
<head>
    <title>Add Certificate</title>
</head>
<body>
<h1>Add Certificate to Task</h1>

<form action="index.php?action=addCertificate&task_id=<?= $taskId; ?>" method="POST">
    <label>Certificate Name: <input type="text" name="certificate_name" required></label><br>
    <label>Date Awarded: <input type="date" name="date_awarded" required></label><br>
    <button type="submit">Add Certificate</button>
</form>

<a href="index.php?action=showTask&id=<?= $taskId; ?>">Back to Task Details</a>
</body>
</html>
