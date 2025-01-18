<?php

namespace DonationModule\Views;

class PaymentStrategiesView
{
    public function render($totalCartAmount)
    {
        echo "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;'>
            <h2 style='text-align: center; color: #333; font-weight: bold;'>Payment Summary</h2>
            <div style='font-size: 16px; color: #555; margin-bottom: 20px;'>
                <!--<p><strong>Quantity:</strong> </p>-->
               <!-- <p><strong>Price per item:</strong> $</p>-->
                <p><strong>Total Amount without fees or VAT :</strong> $$totalCartAmount</p>
            </div>
            <form method='POST' action='?action=choosePayment' style='display: flex; flex-direction: column; gap: 15px;'>
    <label for='paymentMethod' style='font-size: 16px; color: #555;'>Select Payment Method:</label>
    <select id='paymentMethod' name='paymentMethod' required style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'>
        <option value='' disabled selected>Select a payment method</option>
        <option value='creditCard'>Credit Card</option>
        <option value='paypal'>PayPal</option>
        <option value='banktransfer'>Bank Transfer</option>
    </select>
    <button 
        type='submit' 
        style='background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;'>
        Confirm Payment
    </button>
</form>

        </div>";
    }
}

?>
