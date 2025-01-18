<?php
$personId = isset($_GET['person_id']) && is_numeric($_GET['person_id']) ? intval($_GET['person_id']) : null;

if (!$personId) {
    echo "<h1>Error: Invalid or missing person ID.</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skill to Volunteer</title>
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
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Add Skill to Volunteer</h1>

    <form action="index.php?action=add_skill&person_id=<?= htmlspecialchars($personId); ?>" method="POST">
        <label for="skill_id">Select Skill:</label>
        <select name="skill_id" id="skill_id">
            <?php foreach ($allSkills as $skill): ?>
                <option value="<?= htmlspecialchars($skill['id']); ?>">
                    <?= htmlspecialchars($skill['skill']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add Skill</button>
    </form>

    <a href="index.php?action=volunteer_skills&person_id=<?= htmlspecialchars($personId); ?>">Back to Skills</a>
</div>
</body>
</html>
