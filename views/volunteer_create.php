<!DOCTYPE html>
<html>
<head>
    <title>Add Volunteer</title>
</head>
<body>
<h1>Add New Volunteer</h1>
<form action="index.php?action=create" method="POST">
    <label>Name: <input type="text" name="name"></label><br>
    <label>Email: <input type="email" name="email"></label><br>
    <label>Phone: <input type="text" name="phone"></label><br>
    <label>Address: <textarea name="address"></textarea></label><br>
    <label>Joined Date: <input type="date" name="joined_date"></label><br>
    <label>Role: <input type="text" name="role"></label><br>
    <label>Status:
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </label><br>
    <button type="submit">Save</button>
</form>
</body>
</html>
