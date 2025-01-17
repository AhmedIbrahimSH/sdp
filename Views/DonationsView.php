<?php

namespace Views;
class DonationsView
{
    // Method to display the donations table
    public function renderDonationsTable($donations)
    {
        $html = "
        <div style='font-family: Arial, sans-serif; margin: 20px;'>
            <h1 style='text-align: center; color: #2c3e50;'>Donations</h1>
            
            <div style='text-align: center; margin-bottom: 20px;'>
                <button style='background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;' 
                        onclick='window.location.href=\"?action=addDonation\"'>
                    Add Donation
                </button>
            </div>
            
            <table style='width: 100%; border-collapse: collapse; margin: 0 auto; background-color: #f9f9f9;'>
                <thead>
                    <tr style='background-color: #34495e; color: white;'>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Donation ID</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Donation Type</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Donation Date</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Payment Method</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Total Amount</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Quantity</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Amount Per Item</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Person ID</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ";

        // Check if there are any donations
        if (!empty($donations)) {
            // Iterate through the donations array to populate the table
            foreach ($donations as $donation) {
                $amountPerItem = $donation['Quantity'] > 0 ? number_format($donation['TotalAmount'] / $donation['Quantity'], 2) : 'N/A';

                $html .= "
                    <tr style='text-align: center;'>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['DonationID']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['DonationType']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['DonationDate']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['PaymentMethod']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['TotalAmount']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['Quantity']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$amountPerItem}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>{$donation['PersonID']}</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>
                            <button style='background-color: #3498db; color: white; padding: 5px 10px; border: none; border-radius: 3px; margin-right: 5px; cursor: pointer;' 
                                    onclick='window.location.href=\"?action=updateDonation&id={$donation['DonationID']}\"'>
                                Update
                            </button>
                            <button style='background-color: #e74c3c; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;' 
                                    onclick='confirmDeletion({$donation['DonationID']})'>
                                Delete
                            </button>
                        </td>
                    </tr>
                ";
            }
        } else {
            // If no donations, display a message
            $html .= "
                <tr>
                    <td colspan='9' style='text-align: center; padding: 20px; color: #7f8c8d;'>No donations found.</td>
                </tr>
            ";
        }

        $html .= "
                </tbody>
            </table>
        </div>
        
        <script>
            function confirmDeletion(donationID) {
                if (confirm('Are you sure you want to delete this donation?')) {
                    window.location.href = '?action=deleteDonation&id=' + donationID;
                }
            }
        </script>
        ";

        return $html;
    }
}
