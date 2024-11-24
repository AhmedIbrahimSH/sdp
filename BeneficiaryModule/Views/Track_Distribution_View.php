<?php

class Track_Distribution_View
{
    public function Show_Resource_Distribution($allocatedNeeds, $charityStorage)
    {
        // Include CSS for styles
        echo '<link rel="stylesheet" type="text/css" href="Views/styles/dashboard.css">';

        // Main container
        echo '<div class="dashboard-container">';
        echo '<h1>Resource Distribution Dashboard</h1>';

        // Display total allocated needs
        echo '<div class="summary">';
        echo '<h2>Total Allocated Needs: ' . count($allocatedNeeds) . '</h2>';
        echo '</div>';

        // Allocated Needs Table
        echo '<div class="data-table-container">';
        echo '<h3>Allocated Needs</h3>';
        echo '<table class="data-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Resource Type</th>';
        echo '<th>Beneficiary ID</th>';
        echo '<th>Amount</th>';
        echo '<th>RegisterDate</th>';
        echo '<th>Purpose</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($allocatedNeeds as $need) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($need['table']) . '</td>';
            echo '<td>' . htmlspecialchars($need['BeneficiaryID']) . '</td>';
            echo '<td>' . htmlspecialchars($need['Amount']) . '</td>';
            echo '<td>' . htmlspecialchars($need['RegisterDate']) . '</td>';
            echo '<td>' . htmlspecialchars($need['purpose']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        // Charity Storage Table
        echo '<div class="data-table-container">';
        echo '<h3>Charity Storage Overview</h3>';
        echo '<table class="data-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Resource Type</th>';
        echo '<th>Total Amount</th>';
        echo '<th>Spendings</th>';
        echo '<th>Donations</th>';
        echo '<th>Affected Beneficiers</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($charityStorage as $resource) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($resource['type']) . '</td>';
            echo '<td>' . htmlspecialchars($resource['Amount']) . '</td>';
            echo '<td>' . htmlspecialchars($resource['Spendings']) . '</td>';
            echo '<td>' . htmlspecialchars($resource['Donations']) . '</td>';
            echo '<td>' . htmlspecialchars($resource['AffectedPeople']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        // Close main container
        echo '</div>';
    }
}
