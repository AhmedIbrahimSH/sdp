<?php
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
        <h2>Update Donor</h2>

        <form action="../index.php?action=updateDonor&id=<?php echo htmlspecialchars($donor['PersonID']); ?>" method="POST">
            <!-- Personal Information -->
            <h3>Personal Information</h3>
            <label for="firstName">First Name:</label><br>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($donor['FirstName']); ?>" required><br><br>

            <label for="lastName">Last Name:</label><br>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($donor['LastName']); ?>" required><br><br>

            <label for="middleName">Middle Name:</label><br>
            <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($donor['MiddleName']); ?>"><br><br>

            <label for="nationality">Nationality:</label><br>
            <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($donor['Nationality']); ?>" required><br><br>

            <label for="gender">Gender:</label><br>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($donor['Gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($donor['Gender'] === 'Female') echo 'selected'; ?>>Female</option>
            </select><br><br>

            <label for="PersonPhone">Phone:</label><br>
            <input type="text" id="PersonPhone" name="PersonPhone" value="<?php echo htmlspecialchars($donor['PersonPhone']); ?>" required><br><br>

            <!-- Account Information -->
            <h3>Account Information</h3>
            <label for="AccountEmail">Email:</label><br>
            <input type="email" id="AccountEmail" name="AccountEmail" value="<?php echo htmlspecialchars($donor['AccountEmail']); ?>" required><br><br>

            <label for="AccountPasswordHashed">Password (Hashed):</label><br>
            <input type="text" id="AccountPasswordHashed" name="AccountPasswordHashed" value="<?php echo htmlspecialchars($donor['AccountPasswordHashed']); ?>" disabled><br><br>

            <label for="password">New Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter new password"><br><br>

            <label for="status">Status:</label><br>
            <select id="status" name="status" required>
                <option value="Active" <?php if ($donor['status'] === 'Active') echo 'selected'; ?>>Active</option>
                <option value="Inactive" <?php if ($donor['status'] === 'Inactive') echo 'selected'; ?>>Inactive</option>
            </select><br><br>

            <label for="isUser">Is User:</label><br>
            <select id="isUser" name="isUser" required>
                <option value="1" <?php if ($donor['isUser'] == 1) echo 'selected'; ?>>Yes</option>
                <option value="0" <?php if ($donor['isUser'] == 0) echo 'selected'; ?>>No</option>
            </select><br><br>

            <label for="isAccountDeleted">Is Account Deleted:</label><br>
            <select id="isAccountDeleted" name="isAccountDeleted" required>
                <option value="0" <?php if ($donor['isAccountDeleted'] == 0) echo 'selected'; ?>>No</option>
                <option value="1" <?php if ($donor['isAccountDeleted'] == 1) echo 'selected'; ?>>Yes</option>
            </select><br><br>

            <!-- Donor Information -->
            <h3>Donor Information</h3>
            <label for="bloodType">Blood Type:</label><br>
            <input type="text" id="bloodType" name="bloodType" value="<?php echo htmlspecialchars($donor['BloodType']); ?>"><br><br>

            <label for="isDonorDeleted">Is Donor Deleted:</label><br>
            <select id="isDonorDeleted" name="isDonorDeleted" required>
                <option value="0" <?php if ($donor['isDonorDeleted'] == 0) echo 'selected'; ?>>No</option>
                <option value="1" <?php if ($donor['isDonorDeleted'] == 1) echo 'selected'; ?>>Yes</option>
            </select><br><br>

            <input type="submit" value="Update">
        </form>
        <?php
    }
}
