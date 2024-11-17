<?php

class DonationsView
{
    // Method to display the donations table
    public function renderDonationsTable($donations)
    {
        $html = "
        <div>
            <h1>Title: Donations</h1>
            <div style='margin-bottom: 10px;'>
                <button style='background-color: blue; color: white; padding: 5px; border: none; margin-right: 5px;' 
                        onclick='window.location.href=\"?action=addFoodDonation\"'>
                    Add Food Donation
                </button>
                <button style='background-color: green; color: white; padding: 5px; border: none; margin-right: 5px;' 
                        onclick='window.location.href=\"?action=addCashDonation\"'>
                    Add Cash Donation
                </button>
                <button style='background-color: orange; color: white; padding: 5px; border: none; margin-right: 5px;' 
                        onclick='window.location.href=\"?action=addClothesDonation\"'>
                    Add Clothes Donation
                </button>
                <button style='background-color: purple; color: white; padding: 5px; border: none;' 
                        onclick='window.location.href=\"?action=addDrugsDonation\"'>
                    Add Drugs Donation
                </button>
            </div>
            <table border='1' cellspacing='0' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Donation ID</th>
                        <th>Donation Type</th>
                        <th>Donation Date</th>
                        <th>Payment Method</th>
                        <th>Total Amount</th>
                        <th>Person ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ";

        // Iterate through the donations array to populate the table
        foreach ($donations as $donation) {
            $html .= "
                <tr>
                    <td>{$donation['DonationID']}</td>
                    <td>{$donation['DonationType']}</td>
                    <td>{$donation['DonationDate']}</td>
                    <td>{$donation['PaymentMethod']}</td>
                    <td>{$donation['TotalAmount']}</td>
                    <td>{$donation['PersonID']}</td>
                    <td>
                        <button style='background-color: blue; color: white; padding: 5px; border: none;' 
                                onclick='window.location.href=\"?action=updateDonation&id={$donation['DonationID']}\"'>
                            Update
                        </button>
                        <button style='background-color: red; color: white; padding: 5px; border: none;' 
                                onclick='confirmDeletion({$donation['DonationID']})'>
                            Delete
                        </button>
                    </td>
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
