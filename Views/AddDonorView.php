<!-- views/AddDonorView.php -->
<h2>Add Donor</h2>
<form action="../index.php?action=saveDonor" method="POST">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" id="phone" name="phone" required><br><br>

    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" required><br><br>

    <input type="submit" value="Add Donor">
</form>
