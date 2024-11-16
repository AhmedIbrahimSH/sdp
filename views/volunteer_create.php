<!DOCTYPE html>
<html>
<head>
    <title>Add Volunteer</title>
</head>
<body>
<h1>Add Volunteer</h1>

<form action="index.php?action=create_volunteer" method="POST">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" required><br>

    <button type="submit">Add Volunteer</button>
</form>

<a href="index.php?action=index">Back to List</a>
</body>
</html>
