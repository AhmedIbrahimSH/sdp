<?php

class AddFoodDonationView
{
    public function render($donationDetails = [])
    {
        $rows = '';
        foreach ($donationDetails as $donation) {
            $rows .= "
            <tr>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['DonationID']}</td>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['DonationDate']}</td>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['PaymentMethod']}</td>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['Quantity']}</td>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['TotalAmount']}</td>
                <td style='border: 1px solid #ddd; padding: 10px;'>{$donation['PersonID']}</td>
            </tr>
            ";
        }

        $html = "
    <div style='width: 70%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
        <h2 style='text-align: center; color: #333;'>Add Food Donation</h2>
        
        <!-- Table for Summary -->
        <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
            <tbody>
                {$rows}
            </tbody>
        </table>
        
        <!-- Form for Adding Donation -->
        <form method='POST' action='?action=addFoodDonationSubmit' style='display: flex; flex-direction: column; gap: 15px;'>
            
            <label for='donationId' style='font-size: 16px; color: #555;'>Donation ID:</label>
            <input 
                type='number' 
                id='donationId' 
                name='DonationID' 
                placeholder='Enter donation ID' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >

            <label for='donationDate' style='font-size: 16px; color: #555;'>Donation Date:</label>
            <input 
                type='date' 
                id='donationDate' 
                name='DonationDate' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >

            <label for='paymentMethod' style='font-size: 16px; color: #555;'>Payment Method:</label>
            <select 
                id='paymentMethod' 
                name='PaymentMethod' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >
                <option value=''>-- Select Payment Method --</option>
                <option value='Bank Transaction'>Bank Transaction</option>
                <option value='PayPal'>PayPal</option>
                <option value='Credit Card'>Credit Card</option>
            </select>
            
            <label for='quantity' style='font-size: 16px; color: #555;'>Quantity:</label>
            <input 
                type='number' 
                id='quantity' 
                name='Quantity' 
                step='1' 
                placeholder='Enter quantity' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >

            <label for='amount' style='font-size: 16px; color: #555;'>Amount (per item):</label>
            <input 
                type='number' 
                id='amount' 
                name='Amount' 
                step='0.01' 
                placeholder='Enter amount per item' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >

            <label for='personId' style='font-size: 16px; color: #555;'>Person ID:</label>
            <input 
                type='number' 
                id='personId' 
                name='PersonID' 
                placeholder='Enter person ID' 
                required 
                style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
            >
            
            <button 
                type='submit' 
                style='background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;'
            >
                Submit Donation
            </button>
        </form>
    </div>
    ";

        echo $html;
    }
}
