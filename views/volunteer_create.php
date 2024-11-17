<form action="index.php?action=create_volunteer" method="POST">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required><br>

    <label for="middle_name">Middle Name:</label>
    <input type="text" name="middle_name" id="middle_name"><br>

    <label for="nationality">Nationality:</label>
    <input type="text" name="nationality" id="nationality" required><br>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>
    <label for="address_id">Address ID:</label>
    <input type="text" name="address_id" id="address_id" required><br>



    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select><br>

    <button type="submit">Add Volunteer</button>
</form>
