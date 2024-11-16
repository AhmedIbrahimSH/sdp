<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
<h1>Create New Event</h1>

<form action="index.php?action=create_event" method="POST">
    <label for="event_name">Event Name:</label>
    <input type="text" name="event_name" id="event_name" required><br>

    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" id="event_date" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea><br>

    <button type="submit">Create Event</button>
</form>

<a href="index.php?action=events">Back to Events</a>
</body>
</html>
