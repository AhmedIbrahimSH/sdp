<!DOCTYPE html>
<html>
<head>
    <title>Task Certificates</title>
</head>
<body>
<h1>Certificates for Task</h1>

<ul>
    <?php foreach ($certificates as $certificate): ?>
        <li>
            <?= htmlspecialchars($certificate['certificate_name']); ?> (Awarded: <?= htmlspecialchars($certificate['date_awarded']); ?>)
            <a href="index.php?action=remove_certificate&certificate_id=<?= htmlspecialchars($certificate['certificate_id']); ?>&task_id=<?= htmlspecialchars($taskId); ?>">Remove</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=add_certificate&task_id=<?= htmlspecialchars($taskId); ?>">Add Certificate</a>
<a href="index.php?action=volunteer_tasks&person_id=<?= htmlspecialchars($personId); ?>">Back to Tasks</a>
</body>
</html>
