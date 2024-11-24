<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
<h1>Edit Event</h1>

<form action="index.php?action=edit_event&id=<?= htmlspecialchars($event['EventID']); ?>" method="POST">
    <label for="event_name">Event Name:</label>
    <input type="text" name="event_name" id="event_name" value="<?= htmlspecialchars($event['EventName']); ?>" required><br>

    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" id="event_date" value="<?= htmlspecialchars($event['EventDate']); ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"><?= htmlspecialchars($event['Description']); ?></textarea><br>

    <button type="submit">Save Changes</button>
</form>

<a href="index.php?action=events">Back to Events</a>
</body>
</html>
