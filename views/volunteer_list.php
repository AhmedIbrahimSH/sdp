<!DOCTYPE html>
<html>
<head>
    <title>Volunteer List</title>
</head>
<body>
<h1>Volunteer List</h1>

<a href="index.php?action=create_volunteer">Add New Volunteer</a>
<ul>
    <?php foreach ($volunteers as $volunteer): ?>
        <li>
            <?= htmlspecialchars($volunteer['first_name'] . ' ' . $volunteer['last_name']); ?>
            <a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($volunteer['person_id']); ?>">View</a>
            <a href="index.php?action=edit_volunteer&person_id=<?= htmlspecialchars($volunteer['person_id']); ?>">Edit</a>
            <a href="index.php?action=delete_volunteer&person_id=<?= htmlspecialchars($volunteer['person_id']); ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
