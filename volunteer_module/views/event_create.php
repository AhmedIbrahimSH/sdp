<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
<h1>Create Event</h1>
<form action="index.php?action=create_event" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea><br>

    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="fundraiser">Fundraiser</option>
        <option value="workshop">Workshop</option>
    </select><br>

    <button type="submit">Create Event</button>
</form>


<a href="index.php?action=events">Back to Events</a>
</body>
</html>
