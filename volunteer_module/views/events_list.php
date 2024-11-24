<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
</head>
<body>
<h1>Event List</h1>

<a href="index.php?action=create_event">Create New Event</a>
<ul>
    <?php foreach ($events as $event): ?>
        <li>
            <?= htmlspecialchars($event['EventName']); ?>
            (<?= htmlspecialchars($event['EventType']); ?>)
            <a href="index.php?action=show_event&id=<?= htmlspecialchars($event['EventID']); ?>">View</a>
            <a href="index.php?action=edit_event&id=<?= htmlspecialchars($event['EventID']); ?>">Edit</a>
            <a href="index.php?action=delete_event&id=<?= htmlspecialchars($event['EventID']); ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
