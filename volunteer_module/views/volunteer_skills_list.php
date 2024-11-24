<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Skills</title>
</head>
<body>
<h1>Skills for Volunteer</h1>

<ul>
    <?php foreach ($skills as $skill): ?>
        <li><?= htmlspecialchars($skill['skill']); ?></li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=add_skill&person_id=<?= htmlspecialchars($personId); ?>">Add Skill</a>
<a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>">Back to Volunteer</a>
</body>
</html>
