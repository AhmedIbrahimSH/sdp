<form action="index.php?action=edit_volunteer&person_id=<?= htmlspecialchars($volunteer['person_id']); ?>" method="POST">
    <!-- First Name -->
    <label for="FirstName">First Name:</label>
    <input type="text" name="firstName" id="FirstName" value="<?= htmlspecialchars($volunteer['FirstName']); ?>" required><br>

    <!-- Last Name -->
    <label for="LastName">Last Name:</label>
    <input type="text" name="lastName" id="LastName" value="<?= htmlspecialchars($volunteer['LastName']); ?>" required><br>

    <!-- Middle Name -->
    <label for="MiddleName">Middle Name:</label>
    <input type="text" name="middleName" id="MiddleName" value="<?= htmlspecialchars($volunteer['MiddleName'] ?? ''); ?>"><br>

    <!-- Nationality -->
    <label for="Nationality">Nationality:</label>
    <input type="text" name="nationality" id="Nationality" value="<?= htmlspecialchars($volunteer['Nationality']); ?>" required><br>

    <!-- Gender -->
    <label for="Gender">Gender:</label>
    <select name="gender" id="Gender" required>
        <option value="Male" <?= $volunteer['Gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?= $volunteer['Gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
    </select><br>

    <!-- Phone -->
    <label for="PersonPhone">Phone:</label>
    <input type="text" name="phone" id="PersonPhone" value="<?= htmlspecialchars($volunteer['PersonPhone']); ?>" required><br>

    <!-- Email -->
    <label for="AccountEmail">Email:</label>
    <input type="email" name="email" id="AccountEmail" value="<?= htmlspecialchars($volunteer['AccountEmail']); ?>" required><br>

    <!-- Address -->
    <label for="AddressID">Address:</label>
    <select name="addressId" id="AddressID">
        <?php foreach ($addresses as $address): ?>
            <option value="<?= htmlspecialchars($address['AddressID']); ?>" <?= $volunteer['AddressID'] == $address['AddressID'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($address['Name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <!-- Status -->
    <label for="Status">Status:</label>
    <select name="status" id="Status" required>
        <option value="Active" <?= $volunteer['Status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?= $volunteer['Status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
    </select><br>

    <button type="submit">Save Changes</button>
</form>
