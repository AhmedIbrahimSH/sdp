<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Beneficiary</title>
    <link rel="stylesheet" href="Views\styles\form.css"> <!-- Link to the CSS file -->
</head>

<body>
    <div class="form-container">
        <h1>Create New Beneficiary</h1>

        <form action="index.php?action=create_beneficiary" method="POST">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="form-group">
                <label for="middleName">Middle Name (optional)</label>
                <input type="text" id="middleName" name="middleName">
            </div>

            <div class="form-group">
                <label for="nationality">Beneficiary Type</label>
                <select id="nationality" name="nationality" required>
                    <option value="Egyptian">Egyptian</option>
                    <option value="Foreign">Foreign</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="addressID">Address ID</label>
                <input type="number" id="addressID" name="addressID" required>
            </div>

            <div class="form-group">
                <label for="income">Income</label>
                <input type="number" step="0.01" id="income" name="income" required>
            </div>

            <div class="form-group">
                <label for="bloodType">Blood Type</label>
                <select id="bloodType" name="bloodType" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>

            <div class="form-group-checkbox">
                <label for="hasChronicDisease">
                    <input type="checkbox" id="hasChronicDisease" name="hasChronicDisease">
                    Has Chronic Disease
                </label>
            </div>

            <div class="form-group-checkbox">
                <label for="hasDisability">
                    <input type="checkbox" id="hasDisability" name="hasDisability">
                    Has Disability
                </label>
            </div>

            <div class="form-group-checkbox">
                <label for="isHomeless">
                    <input type="checkbox" id="isHomeless" name="isHomeless">
                    Is Homeless
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Create Beneficiary</button>
            </div>
        </form>
    </div>
</body>

</html>