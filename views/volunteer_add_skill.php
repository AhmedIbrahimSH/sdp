<!DOCTYPE html>
<html>
<head>
    <title>Add Skill</title>
</head>
<body>
<h1>Add Skill to Volunteer</h1>

<form action="index.php?action=addSkill&id=<?= htmlspecialchars($volunteerId) ?>" method="POST">
    <label>Skill: <input type="text" name="skill" required></label><br>
    <button type="submit">Add Skill</button>
</form>

<a href="index.php?action=show&id=<?= htmlspecialchars($volunteerId) ?>">Back to Volunteer Details</a>
</body>
</html>
