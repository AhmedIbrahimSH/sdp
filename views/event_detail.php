<!DOCTYPE html>
<html>
<head>
    <title>Event Details</title>
</head>
<body>
<h1>Event Details</h1>

<p><strong>Name:</strong> <?= htmlspecialchars($event['EventName']); ?></p>
<p><strong>Date:</strong> <?= htmlspecialchars($event['EventDate']); ?></p>
<p><strong>Description:</strong> <?= htmlspecialchars($event['Description']); ?></p>

<h2>Assigned Volunteers</h2>
<ul>
    <?php foreach ($volunteers as $volunteer): ?>
        <li><?= htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?></li>

    <?php endforeach; ?>
</ul>

<a href="index.php?action=assign_volunteer&id=<?= htmlspecialchars($event['EventID']); ?>">Assign Volunteer</a>
<a href="index.php?action=events">Back to Events</a>
</body>
</html>
