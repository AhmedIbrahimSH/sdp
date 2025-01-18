<?php

namespace DonationModule\Views;
class AddCashDonationView
{
    public function render()
    {
        $html = "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
            <h2 style='text-align: center; color: #333;'>Add Cash Donation</h2>
            <form method='POST' action='?action=addCashDonationPayment' style='display: flex; flex-direction: column; gap: 15px;'>
                <label for='amount' style='font-size: 16px; color: #555;'>Donation Amount:</label>
                <input 
                    type='number' 
                    id='amount' 
                    name='Amount' 
                    step='0.01' 
                    placeholder='Enter amount' 
                    required 
                    style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
                >
                
                <button 
                    type='submit' 
                    style='background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;'
                >
                    Proceed with Paying
                </button>
            </form>
        </div>
        ";

        echo $html;
    }
}
