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

    <h2>Tasks</h2>
    <ul>
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong>Task Name:</strong> <?= htmlspecialchars($task['task_name']); ?><br>
                    <strong>Description:</strong> <?= htmlspecialchars($task['description']); ?><br>
                    <strong>Due Date:</strong> <?= htmlspecialchars($task['due_date']); ?><br>

                    <?php if (!empty($task['certificate'])): ?>
                        <strong>Certificate:</strong> <?= htmlspecialchars($task['certificate']['certificate_name']); ?> - Awarded on: <?= htmlspecialchars($task['certificate']['date_awarded']); ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tasks assigned.</p>
        <?php endif; ?>
    </ul>

    <a href="index.php?action=addTask&id=<?= htmlspecialchars($volunteer['id']); ?>">Add Task</a>
<?php else: ?>
    <p>Volunteer not found.</p>
<?php endif; ?>

<a href="index.php?action=index">Back to Volunteer List</a>
</body>
</html>
