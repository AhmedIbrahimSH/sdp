<!DOCTYPE html>
<html>
<head>
    <title>Edit Volunteer</title>
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
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007BFF;
            outline: none;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h1>Edit Volunteer</h1>
<form action="index.php?action=edit_volunteer&person_id=<?= htmlspecialchars($volunteer['PersonID']); ?>" method="POST">
    <!-- First Name -->
    <div class="form-group">
        <label for="FirstName">First Name:</label>
        <input type="text" name="firstName" id="FirstName" value="<?= htmlspecialchars($volunteer['FirstName']); ?>" required>
    </div>

    <!-- Last Name -->
    <div class="form-group">
        <label for="LastName">Last Name:</label>
        <input type="text" name="lastName" id="LastName" value="<?= htmlspecialchars($volunteer['LastName']); ?>" required>
    </div>

    <!-- Middle Name -->
    <div class="form-group">
        <label for="MiddleName">Middle Name:</label>
        <input type="text" name="middleName" id="MiddleName" value="<?= htmlspecialchars($volunteer['MiddleName'] ?? ''); ?>">
    </div>

    <!-- Nationality -->
    <div class="form-group">
        <label for="Nationality">Nationality:</label>
        <input type="text" name="nationality" id="Nationality" value="<?= htmlspecialchars($volunteer['Nationality']); ?>" required>
    </div>

    <!-- Gender -->
    <div class="form-group">
        <label for="Gender">Gender:</label>
        <select name="gender" id="Gender" required>
            <option value="Male" <?= $volunteer['Gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?= $volunteer['Gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
        </select>
    </div>

    <!-- Phone -->
    <div class="form-group">
        <label for="PersonPhone">Phone:</label>
        <input type="text" name="phone" id="PersonPhone" value="<?= htmlspecialchars($volunteer['Phone']); ?>" required>
    </div>

    <!-- Email -->
    <div class="form-group">
        <label for="AccountEmail">Email:</label>
        <input type="email" name="email" id="AccountEmail" value="<?= htmlspecialchars($volunteer['Email']); ?>" required>
    </div>





    <button type="submit">Save Changes</button>
</form>
</body>
</html>