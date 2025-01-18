<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Volunteer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            max-height: 90vh; /* Limit height to 90% of the viewport */
            overflow-y: auto; /* Enable vertical scrolling if needed */
        }

        .form-container h2 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        function hashPassword() {
            const passwordInput = document.getElementById('password');
            const password = passwordInput.value;

            const hashedPassword = CryptoJS.SHA256(password).toString();

            document.getElementById('hashed_password').value = hashedPassword;

            passwordInput.value = '';
        }
    </script>
</head>
<body>
<div class="form-container">
    <h2>Create Volunteer</h2>
    <form action="index.php?action=create_volunteer" method="POST">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>
        </div>

        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" id="middle_name">
        </div>

        <div class="form-group">
            <label for="nationality">Nationality:</label>
            <select name="nationality" id="nationality" required>
                <option value="">Select Nationality</option>
                <?php foreach ($nationalities as $nationality): ?>
                    <option value="<?php echo htmlspecialchars($nationality); ?>">
                        <?php echo htmlspecialchars($nationality); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <!-- Hidden field to store the hashed password -->
            <input type="hidden" name="hashed_password" id="hashed_password">
        </div>
        <div class="form-group">
            <label for="address_id">Address ID:</label>
            <input type="text" name="address_id" id="address_id" required>
        </div>



        <div class="form-group">
            <button type="submit">Add Volunteer</button>
        </div>
    </form>
</div>
</body>
</html>