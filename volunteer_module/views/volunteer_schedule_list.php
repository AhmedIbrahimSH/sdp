<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Schedule</title>
</head>
<body>
<h1>Schedule for Volunteer</h1>

<ul>
    <?php foreach ($scheduleItems as $item): ?>
        <li>
            <?= htmlspecialchars($item['schedule_date']); ?>: <?= htmlspecialchars($item['hours']); ?> hours
            <a href="index.php?action=edit_schedule&schedule_id=<?= htmlspecialchars($item['schedule_id']); ?>">Edit</a>
            <a href="index.php?action=remove_schedule&schedule_id=<?= htmlspecialchars($item['schedule_id']); ?>&person_id=<?= htmlspecialchars($personId); ?>">Remove</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=add_schedule&person_id=<?= htmlspecialchars($personId); ?>">Add Schedule</a>
<a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>">Back to Volunteer</a>
</body>
</html>
