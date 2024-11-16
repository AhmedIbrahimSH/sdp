<!DOCTYPE html>
<html>
<head>
    <title>Edit Volunteer</title>
</head>
<body>
<h1>Edit Volunteer</h1>

<form action="index.php?action=edit_volunteer&person_id=<?= htmlspecialchars($volunteer['person_id']); ?>" method="POST">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($volunteer['first_name']); ?>" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($volunteer['last_name']); ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($volunteer['email']); ?>" required><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($volunteer['phone']); ?>" required><br>

    <button type="submit">Save Changes</button>
</form>

<a href="index.php?action=index">Back to List</a>
</body>
</html>
