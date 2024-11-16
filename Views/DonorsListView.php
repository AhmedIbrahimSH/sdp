<?php

class DonorsListView {
    public function display($donors) {
        echo "<h1>Title: Donors</h1>";

        // Display Add Donor button
        echo '<a href="../index.php?action=addDonor" style="margin-bottom: 10px; display: inline-block;" class="btn btn-add">Add Donor</a>';

        echo '<link rel="stylesheet" type="text/css" href="../Public/CSS/CRUD_Buttons.css">';
        // Start the table
        echo '<table border="1" cellpadding="10" cellspacing="0">';

        // Table headers
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th>';
        echo '<th>Address</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        // Check if there are any donors
        if (!empty($donors)) {
            // Loop through each donor and display their details in a row
            foreach ($donors as $donor) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($donor['personID']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['name']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['email']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['phone']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['address']) . '</td>';

                // Action links
                echo '<td>';
                echo '<a href="index.php?action=updateDonor&id=' . htmlspecialchars($donor['personID']) . '" class="btn btn-update">Update</a> | ';
                echo '<a href="index.php?action=deleteDonor&id=' . htmlspecialchars($donor['personID']) . '"class="btn btn-delete" onclick="return confirm(\'Are you sure you want to delete this donor?\');">Delete</a>';
                echo '</td>';

                echo '</tr>';
            }
        } else {
            // No donors found, display an empty row with a message
            echo '<tr>';
            echo '<td colspan="6" style="text-align: center;">No donors added yet.</td>';
            echo '</tr>';
        }

        // End the table
        echo '</table>';
    }
}
