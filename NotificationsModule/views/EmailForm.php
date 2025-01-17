<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email - SDP Charity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px; /* Increased width */
        }
        h1 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="email"],
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 200px; /* Increased height for better visibility */
        }
        button {
            background-color: #0056b3;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #003d80;
        }
        .info {
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Send an Email</h1>
        <form method="POST" action="/email/sendEmail">
            <label for="recipient">Recipient Email:</label>
            <input type="email" id="recipient" name="recipient" placeholder="example@domain.com" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Subject of your email" value="SDP Charity Notification" required>

            <label for="body">Message:</label>
            <textarea id="body" name="body" placeholder="Write your message here..." required>
Thank You for Your Generous Donation!
--------------------------------------

Dear Donor,

On behalf of the SDP Charity Organization, we would like to express our heartfelt gratitude for your generous donation.

Donation Details:

After including applicable VAT at 15%, the total donation amount is:

**Total Amount (After VAT):**

Thank you for being a part of our journey.

Warm regards,  
SDP Charity Organization  
            </textarea>

            <button type="submit">Send Email</button>
        </form>
        <p class="info">This form is automated to help you send personalized notifications.</p>
    </div>
</body>
</html>




<!-- 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>
    <h1>Send an Email</h1>
    <form method="POST" action="/email/sendEmail">
        <label for="recipient">Recipient Email:</label><br>
        <input type="email" id="recipient" name="recipient" required><br><br>

        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="body">Message:</label><br>
        <textarea id="body" name="body" required></textarea><br><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html> -->
