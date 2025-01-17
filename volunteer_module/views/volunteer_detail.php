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

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        a:hover {
            background-color: #0056b3;
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

    <!-- Tasks Section -->
    <h2>Tasks</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['task_name']); ?> (Due: <?= htmlspecialchars($task['due_date']); ?>)
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Schedule Section -->
    <h2>Schedule</h2>
    <ul>
        <?php foreach ($schedule as $item): ?>
            <li>
                <?= htmlspecialchars($item['schedule_date']); ?>: <?= htmlspecialchars($item['hours']); ?> hours
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Back to List Link -->
    <a href="index.php?action=index">Back to List</a>
</div>
</body>
</html>