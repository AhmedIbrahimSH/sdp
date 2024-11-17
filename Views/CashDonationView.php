<?php

class CashDonationView
{
    public function renderDonationsTable($donations)
    {
        $html = "
        <div>
            <h1>Title: Cash Donations</h1>
            <button style='background-color: blue; color: white; padding: 5px; border: none; margin-bottom: 10px;' 
                    onclick='window.location.href=\"?action=cashDonationAdd\"'>
                Add Cash Donation
            </button>
            <table border='1' cellspacing='0' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Donation ID</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach ($donations as $donation) {
            $html .= "
                <tr>
                    <td>{$donation['DonationID']}</td>
                    <td>{$donation['Amount']}</td>
                    <td>
                        <button style='background-color: blue; color: white; padding: 5px; border: none;' 
                                onclick='window.location.href=\"?action=cashDonationUpdate&id={$donation['DonationID']}\"'>
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
                    window.location.href = '?action=cashDonationDelete&id=' + donationID;
                }
            }
        </script>
        ";

        return $html;
    }
}
