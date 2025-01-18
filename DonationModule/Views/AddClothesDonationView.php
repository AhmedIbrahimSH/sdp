<?php

namespace DonationModule\Views;
class AddClothesDonationView
{
    public function render()
    {
        $html = "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
            <h2 style='text-align: center; color: #333;'>Add Clothes Donation</h2>
            <p style='font-size: 14px; color: #888;'>
                Amount per item is predefined and will be calculated automatically.
            </p>
            <form method='POST' action='?action=addClothesDonationSubmit' style='display: flex; flex-direction: column; gap: 15px;'>

                <label for='quantity' style='font-size: 16px; color: #555;'>Quantity:</label>
                <input 
                    type='number' 
                    id='quantity' 
                    name='Quantity' 
                    placeholder='Enter quantity' 
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
