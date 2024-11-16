<!DOCTYPE html>
<html>
<head>
    <title>Add Skill to Volunteer</title>
</head>
<body>
<h1>Add Skill to Volunteer</h1>

<form action="index.php?action=add_skill&person_id=<?= htmlspecialchars($personId); ?>" method="POST">
    <label for="skill_id">Select Skill:</label>
    <select name="skill_id" id="skill_id">
        <?php foreach ($allSkills as $skill): ?>
            <option value="<?= htmlspecialchars($skill['id']); ?>"><?= htmlspecialchars($skill['skill']); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Add Skill</button>
</form>

<a href="index.php?action=volunteer_skills&person_id=<?= htmlspecialchars($personId); ?>">Back to Skills</a>
</body>
</html>
