<?php

namespace Views;
class DonorsListView
{
    public function display($donors)
    {
        // Add basic styling
        echo '<style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 20px;
                background-color: #f4f4f9;
            }
            h1 {
                color: #2c3e50;
                text-align: center;
                margin-bottom: 20px;
            }
            .btn {
                text-decoration: none;
                padding: 10px 15px;
                border-radius: 5px;
                font-size: 14px;
                margin: 0 5px;
            }
            .btn-add {
                background-color: #2ecc71;
                color: white;
            }
            .btn-add:hover {
                background-color: #27ae60;
            }
            .btn-update {
                background-color: #3498db;
                color: white;
            }
            .btn-update:hover {
                background-color: #2980b9;
            }
            .btn-delete {
                background-color: #e74c3c;
                color: white;
            }
            .btn-delete:hover {
                background-color: #c0392b;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background-color: white;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            th, td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            th {
                background-color: #34495e;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
            }
            td a {
                margin: 0 5px;
            }
            td:last-child {
                text-align: center;
            }
        </style>';

        // Title
        echo "<h1>Donors</h1>";

        // Display Add Donor button
        echo '<div style="text-align: center; margin-bottom: 20px;">
                <a href="../index.php?action=addDonor" class="btn btn-add">Add Donor</a>
              </div>';

        // Start the table
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Person ID</th>';
        echo '<th>First Name</th>';
        echo '<th>Last Name</th>';
        echo '<th>Middle Name</th>';
        echo '<th>Nationality</th>';
        echo '<th>Gender</th>';
        echo '<th>Phone</th>';
        echo '<th>Email</th>';
        echo '<th>Country</th>';
        echo '<th>City</th>';
        echo '<th>Street</th>';
        echo '<th>Is Account Deleted</th>';
        echo '<th>Is Donor Deleted</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Check if there are any donors
        if (!empty($donors)) {
            foreach ($donors as $donor) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($donor['PersonID']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['FirstName']) . '</td>';
                echo '<td>' . htmlspecialchars($donor['LastName']) . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['MiddleName']) ? $donor['MiddleName'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Nationality']) ? $donor['Nationality'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Gender']) ? $donor['Gender'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Phone']) ? $donor['Phone'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Email']) ? $donor['Email'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Country']) ? $donor['Country'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['City']) ? $donor['City'] : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars(isset($donor['Street']) ? $donor['Street'] : 'N/A') . '</td>';
                echo '<td>' . (isset($donor['IsAccountDeleted']) && $donor['IsAccountDeleted'] ? 'Yes' : 'No') . '</td>';
                echo '<td>' . (isset($donor['IsDonorDeleted']) && $donor['IsDonorDeleted'] ? 'Yes' : 'No') . '</td>';

                // Action buttons
                echo '<td>';
                echo '<a href="index.php?action=editDonor&id=' . htmlspecialchars($donor['PersonID']) . '" class="btn btn-update">Update</a>';
                echo '<a href="index.php?action=deleteDonor&id=' . htmlspecialchars($donor['PersonID']) . '" class="btn btn-delete" onclick="return confirm(\'Are you sure you want to delete this donor?\');">Delete</a>';
                echo '</td>';

                echo '</tr>';
            }
        } else {
            // No donors found, display an empty message
            echo '<tr>';
            echo '<td colspan="14" style="text-align: center; color: #7f8c8d;">No donors added yet.</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
}
