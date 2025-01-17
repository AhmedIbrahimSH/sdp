<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Tasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0 0 20px;
        }
        li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        li span {
            font-size: 16px;
            color: #333;
        }
        li a {
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
            margin-left: 10px;
        }
        li a:hover {
            text-decoration: underline;
        }
        .actions {
            display: flex;
        }
        a.button {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tasks for Volunteer</h1>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <span><?= htmlspecialchars($task['task_name']); ?> - <?= htmlspecialchars($task['due_date']); ?></span>
                <div class="actions">
                    <a href="index.php?action=edit_task&task_id=<?= htmlspecialchars($task['task_id']); ?>">Edit</a>
                    <a href="index.php?action=remove_task&task_id=<?= htmlspecialchars($task['task_id']); ?>&person_id=<?= htmlspecialchars($personId); ?>">Remove</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php?action=add_task&person_id=<?= htmlspecialchars($personId); ?>" class="button">Add Task</a>
    <a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>" class="button">Back to Volunteer</a>
</div>
</body>
</html>
