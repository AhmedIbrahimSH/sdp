
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

        <form action="/SignUpModule" method="POST">
            <label for="username">User Name</label>
            <input type="text" id="username" name="username" placeholder="Enter your name" required>

            <label for="email">User Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="phone">User Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

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
