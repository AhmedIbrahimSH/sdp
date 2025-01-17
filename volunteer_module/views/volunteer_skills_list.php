<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Skills</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        li {
            background-color: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: left;
        }
        a {
            display: inline-block;
            margin: 10px 5px;
            text-decoration: none;
            color: #007BFF;
            padding: 10px 20px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 14px;
        }
        a:hover {
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Skills for Volunteer</h1>

    <ul>
        <?php foreach ($volunteerSkills as $skill): ?>
            <li><?= htmlspecialchars($skill['skill']); ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php?action=add_skill&person_id=<?= htmlspecialchars($personId); ?>">Add Skill</a>
    <a href="index.php?action=show_volunteer&person_id=<?= htmlspecialchars($personId); ?>">Back to Volunteer</a>
</div>
</body>
</html>
