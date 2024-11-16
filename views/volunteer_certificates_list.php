<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Certificates</title>
</head>
<body>
<h1>Certificates for Volunteer</h1>

<ul>
    <?php foreach ($certificates as $certificate): ?>
        <li>
            <?= htmlspecialchars($certificate['task_name']); ?>: <?= htmlspecialchars($certificate['certificate_name']); ?>
            (Awarded: <?= htmlspecialchars($certificate['date_awarded']); ?>)
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>">Back to Volunteer</a>
</body>
</html>
