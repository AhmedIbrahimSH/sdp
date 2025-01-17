<?php

namespace Views;
class DonorViewUpdate
{
    /**
     * Render the update donor form
     *
     * @param array $donor - Donor data to prefill the form
     * @return void
     */
    public function renderUpdateForm($donor)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Donor</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 20px;
                }

                h2, h3 {
                    color: #2c3e50;
                }

                form {
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                }

                label {
                    font-weight: bold;
                    margin-top: 10px;
                    display: block;
                }

                input, select {
                    width: 100%;
                    padding: 8px;
                    margin-top: 5px;
                    margin-bottom: 15px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                input[type="submit"] {
                    background-color: #3498db;
                    color: white;
                    border: none;
                    cursor: pointer;
                    font-weight: bold;
                }

                input[type="submit"]:hover {
                    background-color: #2980b9;
                }

                .section {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
        <h2>Update Donor</h2>
        <form action="../index.php?action=updateDonor&id=<?php echo htmlspecialchars($donor['PersonID']); ?>"
              method="POST">
            <!-- Personal Information -->
            <div class="section">
                <h3>Personal Information</h3>
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName"
                       value="<?php echo htmlspecialchars($donor['FirstName']); ?>" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName"
                       value="<?php echo htmlspecialchars($donor['LastName']); ?>" required>

                <label for="middleName">Middle Name:</label>
                <input type="text" id="middleName" name="middleName"
                       value="<?php echo htmlspecialchars($donor['MiddleName']); ?>">

                <label for="nationality">Nationality:</label>
                <input type="text" id="nationality" name="nationality"
                       value="<?php echo htmlspecialchars($donor['Nationality']); ?>" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="Male" <?php if ($donor['Gender'] === 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($donor['Gender'] === 'Female') echo 'selected'; ?>>Female</option>
                </select>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($donor['Phone']); ?>"
                       required>
            </div>

            <!-- Address Information -->
            <div class="section">
                <h3>Address</h3>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($donor['City']); ?>"
                       required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country"
                       value="<?php echo htmlspecialchars($donor['Country']); ?>" required>

                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($donor['Street']); ?>"
                       required>
            </div>

            <!-- Account Information -->
            <div class="section">
                <h3>Account Information</h3>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donor['Email']); ?>"
                       required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password"
                       placeholder="Enter new password (leave blank if no change)">
            </div>

            <!-- Submit Button -->
            <input type="submit" value="Update Donor">
        </form>
        </body>
        </html>
        <?php
    }
}
