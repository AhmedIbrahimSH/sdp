<!DOCTYPE html>
<html>
<head>
    <title>Subscribe to Event</title>
</head>
<body>
<h1>Subscribe to Event</h1>

<form action="index.php?action=subscribe_to_event&id=<?= htmlspecialchars($eventId); ?>" method="POST">
    <label for="person_id">Select Volunteer:</label>
    <select name="person_id" id="person_id" required>
        <?php foreach ($volunteers as $volunteer): ?>
            <option value="<?= htmlspecialchars($volunteer['person_id']); ?>">
                <?= htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="event_type">Select Event Type:</label>
    <select name="event_type" id="event_type" required>
        <option value="fundraiser">Fundraiser</option>
        <option value="workshop">Workshop</option>
    </select><br>

    <button type="submit">Subscribe</button>
</form>

<a href="index.php?action=index">Back to Events</a>
</body>
</html>
