<!DOCTYPE html>
<html>
<head>
    <title>Edit Volunteer</title>
</head>
<body>
<h1>Edit Volunteer</h1>

<?php if (!empty($volunteer)): ?>
    <form action="index.php?action=update&id=<?= htmlspecialchars($volunteer['id']); ?>" method="POST">
        <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($volunteer['name']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($volunteer['email']); ?>" required></label><br>
        <label>Phone: <input type="text" name="phone" value="<?= htmlspecialchars($volunteer['phone']); ?>"></label><br>
        <label>Address: <textarea name="address"><?= htmlspecialchars($volunteer['address']); ?></textarea></label><br>
        <label>Joined Date: <input type="date" name="joined_date" value="<?= htmlspecialchars($volunteer['joined_date']); ?>"></label><br>
        <label>Role: <input type="text" name="role" value="<?= htmlspecialchars($volunteer['role']); ?>"></label><br>
        <label>Status:
            <select name="status">
                <option value="active" <?= $volunteer['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= $volunteer['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </label><br>
        <button type="submit">Save Changes</button>
    </form>
<?php else: ?>
    <p>Volunteer not found.</p>
<?php endif; ?>

<a href="index.php?action=index">Back to Volunteer List</a>
</body>
</html>
