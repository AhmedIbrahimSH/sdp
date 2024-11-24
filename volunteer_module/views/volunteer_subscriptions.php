<h1>Manage Subscriptions</h1>
<form action="index.php?action=volunteer_subscriptions" method="POST">
    <input type="hidden" name="person_id" value="<?= htmlspecialchars($personId); ?>">

    <label>
        <input type="checkbox" name="subscriptions[]" value="fundraiser"
            <?= in_array('fundraiser', $currentSubscriptions) ? 'checked' : ''; ?>>
        Fundraiser
    </label><br>

    <label>
        <input type="checkbox" name="subscriptions[]" value="workshop"
            <?= in_array('workshop', $currentSubscriptions) ? 'checked' : ''; ?>>
        Workshop
    </label><br>

    <button type="submit">Save Subscriptions</button>
</form>
