<!DOCTYPE html>
<html>
<head>
    <title>Volunteer List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        .add-volunteer {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }
        li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        li:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .volunteer-name {
            font-weight: bold;
            color: #333;
        }
        .actions a {
            margin-left: 10px;
            font-size: 14px;
        }
        .actions a.edit {
            color: #28a745;
        }
        .actions a.delete {
            color: #dc3545;
        }
    </style>
</head>
<body>
<h1>Volunteer List</h1>
<a href="index.php?action=create_volunteer" class="add-volunteer">Add New Volunteer</a>
<ul>
    <?php foreach ($volunteers as $volunteer): ?>
        <?php
        $firstName = htmlspecialchars($volunteer['FirstName'] ?? 'Unknown');
        $lastName = htmlspecialchars($volunteer['LastName'] ?? 'Unknown');
        $personId = htmlspecialchars($volunteer['PersonID'] ?? '');
        ?>
        <li>
            <span class="volunteer-name">
                <?php echo $firstName . ' ' . $lastName; ?>
            </span>
            <span class="actions">
                <?php if ($personId): ?>
                    <a href="index.php?action=show_volunteer&person_id=<?php echo $personId; ?>">View</a>
                    <a href="index.php?action=edit_volunteer&person_id=<?php echo $personId; ?>" class="edit">Edit</a>
                    <a href="index.php?action=delete_volunteer&person_id=<?php echo $personId; ?>" class="delete">Delete</a>
                <?php else: ?>
                    <span style="color: red;">Invalid Volunteer ID</span>
                <?php endif; ?>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>