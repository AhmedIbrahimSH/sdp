<?php

class Beneficiary_List_View
{
    public function showBeneficiaries($beneficiaries)
    {
        // Embedding the CSS directly within the PHP function for modern look
        echo '<link rel="stylesheet" type="text/css" href="Views/styles/list.css">';

        // Output the start of the page and container
        echo '<div class="container">';
        // h1 title in the center that says "Beneficiary Control Panel"
        echo '<h1>Beneficiary Control Panel</h1>';


        // Title and action buttons, "Create" button aligned to the right
        //echo '<h2>Beneficiary List</h2>';
        echo '<div class="actions">';
        echo '<a href="index.php?action=create_beneficiary" class="btn btn-primary">Create New Beneficiary</a>';
        echo '<a href="index.php?action=track_distribution" class="btn btn-primary" style="margin-left: 100px;">Track Recources Distribution</a>';
        echo '</div>';




        // Start of table with improved structure and modern style
        echo '<table>';
        echo '<thead><tr><th>Name</th><th>Phone</th><th>Income</th><th>Has Disability</th><th>Is Homeless</th><th>Has Chronic Disease</th><th>Actions</th></tr></thead>';
        echo '<tbody>';

        // Loop through beneficiaries and display their details
        foreach ($beneficiaries as $beneficiary) {
            echo '<tr>';
            // Name column with a link to view the beneficiary
            echo '<td><a href="index.php?action=view_beneficiary&id=' . urlencode($beneficiary['PersonID']) . '" class="name-link">' . htmlspecialchars($beneficiary['FirstName'] . ' ' . $beneficiary['MiddleName'] . ' ' . $beneficiary['LastName']) . '</a></td>';
            // Phone column
            echo '<td>' . htmlspecialchars($beneficiary['Phone']) . '</td>';
            // Income column
            echo '<td>' . htmlspecialchars($beneficiary['income']) . '</td>';
            // Disability column
            echo '<td>' . ($beneficiary['hasDisability'] ? 'Yes' : 'No') . '</td>';
            // Homeless column
            echo '<td>' . ($beneficiary['isHomeless'] ? 'Yes' : 'No') . '</td>';
            // Chronic Disease column
            echo '<td>' . ($beneficiary['hasChronicDisease'] ? 'Yes' : 'No') . '</td>';
            // Actions column (Update and Delete buttons)
            echo '<td class="action-buttons">';
            echo '<a href="index.php?action=update_beneficiary&id=' . urlencode($beneficiary['PersonID']) . '" class="btn btn-warning">Update</a>';
            echo ' <a href="index.php?action=delete_beneficiary&id=' . urlencode($beneficiary['PersonID']) . '" class="btn btn-danger"onclick="return confirm(\'Are you sure you want to delete this Beneficier?\');">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        // End table
        echo '</tbody>';
        echo '</table>';

        // Close container
        echo '</div>';
    }
}
