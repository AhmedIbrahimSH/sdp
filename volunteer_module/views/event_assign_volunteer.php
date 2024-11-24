<!DOCTYPE html>
<html>
<head>
    <title>Assign Volunteer to Event</title>
</head>
<body>
<h1>Assign Volunteer to Event</h1>

<form action="index.php?action=assign_volunteer&id=<?= htmlspecialchars($eventId); ?>" method="POST">
    <label for="person_id">Select Volunteer:</label>
    <select name="person_id" id="person_id" required>
        <?php foreach ($availableVolunteers as $volunteer): ?>
            <option value="<?= htmlspecialchars($volunteer['person_id']); ?>">
                <?= htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Assign Volunteer</button>
</form>

<a href="index.php?action=show_event&id=<?= htmlspecialchars($eventId); ?>">Back to Event</a>
</body>
</html>
