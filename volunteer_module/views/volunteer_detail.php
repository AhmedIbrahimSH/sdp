<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #007bff;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        p {
            margin: 10px 0;
            font-size: 16px;
        }

        p strong {
            color: #555;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #007bff;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .actions a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .back-link:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Volunteer Details</h1>

    <!-- Volunteer Information -->
    <p><strong>Name:</strong> <?= htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($volunteer['Email']); ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($volunteer['Phone']); ?></p>

    <!-- Skills Section -->
    <h2>Skills</h2>
    <ul>
        <?php foreach ($skills as $skill): ?>
            <li><?= htmlspecialchars($skill['skill']); ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="actions">
        <a href="index.php?action=add_skill&person_id=<?= htmlspecialchars($volunteer['PersonID']); ?>">Add Skill</a>
    </div>

    <!-- Tasks Section -->
    <h2>Tasks</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['task_name']); ?> (Due: <?= htmlspecialchars($task['due_date']); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="actions">
        <a href="index.php?action=add_task&person_id=<?= htmlspecialchars($volunteer['PersonID']); ?>">Add Task</a>
    </div>

    <!-- Schedule Section -->
    <h2>Schedule</h2>
    <ul>
        <?php foreach ($schedule as $item): ?>
            <li>
                <?= htmlspecialchars($item['schedule_date']); ?>: <?= htmlspecialchars($item['hours']); ?> hours
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="actions">
        <a href="index.php?action=add_schedule&person_id=<?= htmlspecialchars($volunteer['PersonID']); ?>">Add Schedule</a>
    </div>

    <!-- Certificates Section -->
    <h2>Certificates</h2>
    <ul>
        <?php if (!empty($certificates) && is_array($certificates)): ?>
            <?php foreach ($certificates as $certificate): ?>
                <li>
                    <?= htmlspecialchars($certificate['certificate_name']); ?> (Issued: <?= htmlspecialchars($certificate['issue_date']); ?>)
                </li>
            <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </ul>

    <div class="actions">
        <a href="index.php?action=add_certificate&person_id=<?= htmlspecialchars($volunteer['PersonID']); ?>">Add Certificate</a>
    </div>

    <!-- Back to List Link -->
    <a href="index.php?action=index" class="back-link">Back to List</a>
</div>
</body>
</html>