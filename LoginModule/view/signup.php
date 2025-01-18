<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if (isset($error) && $error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/LoginModule/controller/SignUpController.php" method="POST">

            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="First Name" required>

            <label for="middlename">Middle Name</label>
            <input type="text" id="middlename" name="middlename" placeholder="Middle Name" required>
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
            <label for="email">User Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>


            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>


            <label for="phone">User Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Nationality" required>


            <label for="address">Address</label>
            <select id="address" name="address" required>
                <option value="">New York</option>
                <option value="Oxford Street">The Egyptian Museum</option>
                <option value="Yonge Street">Cairo Tower</option>
                <option value="London">Pyramids of Giza</option>

            </select><br><br>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="fundraiser">Male</option>
                <option value="program">Female</option>
                <option value="workshop">HAHAHA</option>
            </select>
            <label for="events">Events Interested In</label>
            <select id="events" name="events[]" multiple required>
                <option value="fundraiser">Fundraiser</option>
                <option value="program">Program</option>
                <option value="workshop">Workshop</option>
            </select>

            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>

</html>