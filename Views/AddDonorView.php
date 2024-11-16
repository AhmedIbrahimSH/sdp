<!-- views/AddDonorView.php -->
<h2>Add Donor</h2>
<form action="../index.php?action=saveDonor" method="POST">
    <!-- Personal Information -->
    <h3>Personal Information</h3>
    <label for="firstName">First Name:</label><br>
    <input type="text" id="firstName" name="firstName" required><br><br>

    <label for="lastName">Last Name:</label><br>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="middleName">Middle Name:</label><br>
    <input type="text" id="middleName" name="middleName"><br><br>

    <label for="nationality">Nationality:</label><br>
    <input type="text" id="nationality" name="nationality" required><br><br>

    <label for="gender">Gender:</label><br>
    <select id="gender" name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" id="phone" name="phone" required><br><br>

    <!-- Address -->
    <h3>Address</h3>
    <label for="city">City:</label><br>
    <input type="text" id="city" name="city" required><br><br>

    <label for="country">Country:</label><br>
    <input type="text" id="country" name="country" required><br><br>

    <label for="street">Street:</label><br>
    <input type="text" id="street" name="street" required><br><br>

    <label for="buildingNo">Building No:</label><br>
    <input type="text" id="buildingNo" name="buildingNo" required><br><br>

    <label for="apartmentNo">Apartment No:</label><br>
    <input type="text" id="apartmentNo" name="apartmentNo"><br><br>

    <!-- Account Information -->
    <h3>Account Information</h3>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="status">Status:</label><br>
    <select id="status" name="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select><br><br>

    <label for="isUser">Is User:</label><br>
    <select id="isUser" name="isUser" required>
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select><br><br>

    <label for="isAccountDeleted">Is Account Deleted:</label><br>
    <select id="isAccountDeleted" name="isAccountDeleted" required>
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select><br><br>

    <!-- Donor Information -->
    <h3>Donor Information</h3>
    <label for="bloodType">Blood Type:</label><br>
    <input type="text" id="bloodType" name="bloodType" required><br><br>

    <label for="isDonorDeleted">Is Donor Deleted:</label><br>
    <select id="isDonorDeleted" name="isDonorDeleted" required>
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select><br><br>

    <input type="submit" value="Add Donor">
</form>
