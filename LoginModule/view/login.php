<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-container">
    <!-- Centered image -->
    <img src="https://png.pngtree.com/png-vector/20220712/ourmid/pngtree-hand-shake-social-charity-logo-png-image_5888875.png" alt="Site Logo" class="login-logo">

    <h2>Login</h2>

    <!-- Error message -->
    <?php if (isset($error) && $error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Login form -->
    <form action="/LoginModule" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <!-- Sign Up button -->
    <div class="signup-link">
        <p>Don't have an account?</p>
        <a href="/SignUpModule" class="signup-button">Sign Up</a>
    </div>
</div>
</body>
</html>
