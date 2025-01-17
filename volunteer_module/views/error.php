<?php
// app/views/error.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
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

        .error-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .error-container h1 {
            color: #d9534f; /* Bootstrap's danger color */
            font-size: 24px;
            margin-bottom: 20px;
        }

        .error-container p {
            color: #333;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .error-container a {
            color: #007bff; /* Bootstrap's primary color */
            text-decoration: none;
            font-size: 14px;
        }

        .error-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>Oops! Something went wrong.</h1>
    <p><?php echo htmlspecialchars($error); ?></p>
    <a href="index.php">Go back to the homepage</a>
</div>
</body>
</html>