<!DOCTYPE html>
<html>
<head>
    <title>Volunteer List</title>
</head>
<body>
<h1>Volunteers</h1>

<a href="index.php?action=create">Add Volunteer</a>
<ul>
    <?php if (!empty($volunteers)): ?>
        <?php foreach ($volunteers as $volunteer): ?>
            <li>
                <?= htmlspecialchars($volunteer['name']) ?>
                <a href="index.php?action=show&id=<?= urlencode($volunteer['id']) ?>">View</a>
                <a href="index.php?action=update&id=<?= urlencode($volunteer['id']) ?>">Edit</a>
                <a href="index.php?action=delete&id=<?= urlencode($volunteer['id']) ?>">Delete</a>


            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No volunteers found.</p>
    <?php endif; ?>
</ul>
</body>
</html>
