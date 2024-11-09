<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Details</title>
</head>
<body>
<h1>Volunteer Details</h1>

<?php if (!empty($volunteer)): ?>
    <p><strong>Name:</strong> <?= htmlspecialchars($volunteer['name']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($volunteer['email']); ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($volunteer['phone']); ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($volunteer['address']); ?></p>
    <p><strong>Joined Date:</strong> <?= htmlspecialchars($volunteer['joined_date']); ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($volunteer['role']); ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($volunteer['status']); ?></p>
<?php else: ?>
    <p>Volunteer not found.</p>
<?php endif; ?>

<a href="index.php?action=index">Back to Volunteer List</a>
</body>
</html>
<?php
