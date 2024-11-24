<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Tasks</title>
</head>
<body>
<h1>Tasks for Volunteer</h1>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?= htmlspecialchars($task['task_name']); ?> - <?= htmlspecialchars($task['due_date']); ?>
            <a href="index.php?action=edit_task&task_id=<?= htmlspecialchars($task['task_id']); ?>">Edit</a>
            <a href="index.php?action=remove_task&task_id=<?= htmlspecialchars($task['task_id']); ?>&person_id=<?= htmlspecialchars($personId); ?>">Remove</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=add_task&person_id=<?= htmlspecialchars($personId); ?>">Add Task</a>
<a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>">Back to Volunteer</a>
</body>
</html>
