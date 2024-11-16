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
        echo '<th>Person ID</th>';
        echo '<th>First Name</th>';
        echo '<th>Last Name</th>';
        echo '<th>Middle Name</th>';
        echo '<th>Nationality</th>';
        echo '<th>Gender</th>';
        echo '<th>Phone</th>';
        //echo '<th>Address ID</th>';
        echo '<th>Email</th>';
        echo '<th>Password (Hashed)</th>';
        echo '<th>Status</th>';
        echo '<th>Is User</th>';
        echo '<th>Is Account Deleted</th>';
        echo '<th>Blood Type</th>';
        echo '<th>Is Donor Deleted</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        // Check if there are any donors
        if (!empty($donors)) {
            // Loop through each donor and display their details in a row
            foreach ($donors as $donor) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($donor['PersonID']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['FirstName']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['LastName']) . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['MiddleName']) ? $donor['MiddleName'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Nationality']) ? $donor['Nationality'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Gender']) ? $donor['Gender'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['PersonPhone']) ? $donor['PersonPhone'] : 'N/A') . '</td>';
                //echo '<td>' . htmlspecialchars(isset($donor['AddressID']) ? $donor['AddressID'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['AccountEmail']) ? $donor['AccountEmail'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['AccountPasswordHashed']) ? $donor['AccountPasswordHashed'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Status']) ? $donor['Status'] : 'N/A') . '</td>';
                echo '<td>' . (isset($donor['IsUser']) && $donor['IsUser'] ? 'Yes' : 'No') . '</td>';
                echo '<td>' . (isset($donor['IsAccountDeleted']) && $donor['IsAccountDeleted'] ? 'Yes' : 'No') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['BloodType']) ? $donor['BloodType'] : 'N/A') . '</td>';
                echo '<td>' . (isset($donor['IsDonorDeleted']) && $donor['IsDonorDeleted'] ? 'Yes' : 'No') . '</td>';

                // Action links
                echo '<td>';
                echo '<a href="index.php?action=editDonor&id=' . htmlspecialchars($donor['PersonID']) . '" class="btn btn-update">Update</a> | ';
                echo '<a href="index.php?action=deleteDonor&id=' . htmlspecialchars($donor['PersonID']) . '" class="btn btn-delete" onclick="return confirm(\'Are you sure you want to delete this donor?\');">Delete</a>';
                echo '</td>';

                echo '</tr>';
            }
        } else {
            // No donors found, display an empty row with a message
            echo '<tr>';
            echo '<td colspan="16" style="text-align: center;">No donors added yet.</td>';
            echo '</tr>';
        }

        // End the table
        echo '</table>';
    }
}
