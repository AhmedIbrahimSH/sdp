<?php

namespace Views;
class DonorView
{

    // Method to display donor information
    public function display($donor)
    {
        if (!isset($donor['name']) || !isset($donor['email']) || !isset($donor['phone']) || !isset($donor['address'])) {
            echo "<p>Invalid donor information provided.</p>";
            return;
        }
        ?>
        <h1>Donor Information</h1>
        <p>Name: <?php echo htmlspecialchars($donor['name']); ?></p>
        <p>Email: <?php echo htmlspecialchars($donor['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($donor['phone']); ?></p>
        <p>Address: <?php echo htmlspecialchars($donor['address']); ?></p>
        <?php
    }
}
