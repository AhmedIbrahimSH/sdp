<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Details</title>
</head>
<body>
<h1>Volunteer Details</h1>
<p><strong>Name:</strong> <?= htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($volunteer['AccountEmail']); ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($volunteer['PersonPhone']); ?></p>

<h2>Skills</h2>
<ul>
    <?php foreach ($skills as $skill): ?>
        <li><?= htmlspecialchars($skill['skill']); ?></li>
    <?php endforeach; ?>
</ul>

<h2>Tasks</h2>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?= htmlspecialchars($task['task_name']); ?> (Due: <?= htmlspecialchars($task['due_date']); ?>)
        </li>
    <?php endforeach; ?>
</ul>

<h2>Schedule</h2>
<ul>
    <?php foreach ($schedule as $item): ?>
        <li>
            <?= htmlspecialchars($item['schedule_date']); ?>: <?= htmlspecialchars($item['hours']); ?> hours
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=index">Back to List</a>
</body>
</html>
