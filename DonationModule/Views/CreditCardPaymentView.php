<?php

namespace DonationModule\Views;

class CreditCardPaymentView
{
    public function render()
    {
        $amount = 600;
        // Define tax and transaction fee decorators
        $vat = 0.15 * $amount; // 15% VAT
        $transactionFee = 5.00; // Fixed transaction fee
        $totalAmount = $amount + $vat + $transactionFee;

        echo "
        <div style='display: flex; justify-content: center; align-items: flex-start; gap: 20px; padding: 30px; background: #f4f4f9; font-family: Arial, sans-serif;'>
            <!-- Invoice Section -->
            <div style='background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 300px;'>
                <h2 style='text-align: center; color: #333; margin-bottom: 20px;'>Invoice</h2>
                <p style='color: #555; font-size: 16px;'>Base Amount: <strong>\$$amount</strong></p>
                <p style='color: #555; font-size: 16px;'>VAT (15%): <strong>\$$vat</strong></p>
                <p style='color: #555; font-size: 16px;'>Transaction Fee: <strong>\$$transactionFee</strong></p>
                <hr style='margin: 20px 0; border: 0; border-top: 1px solid #ddd;'>
                <p style='color: #333; font-size: 18px; font-weight: bold;'>Total Amount: <strong>\$$totalAmount</strong></p>
            </div>

            <!-- Payment Form Section -->
            <div style='background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%;'>
                <h2 style='text-align: center; color: #333; margin-bottom: 20px;'>Credit Card Payment</h2>
                <form method='POST' action='?action=confirmCreditCardPayment' style='display: flex; flex-direction: column; gap: 15px;'>
                    <!-- Card Number -->
                    <label for='cardNumber' style='color: #555;'>Card Number:</label>
                    <input type='text' id='cardNumber' name='cardNumber' required 
                        style='padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;'>
                    
                    <!-- Card Holder Name -->
                    <label for='cardHolderName' style='color: #555;'>Card Holder Name:</label>
                    <input type='text' id='cardHolderName' name='cardHolderName' required 
                        style='padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;'>
                    
                    <!-- Expiry Date -->
                    <label for='expiryDate' style='color: #555;'>Expiry Date:</label>
                    <input type='month' id='expiryDate' name='expiryDate' required 
                        style='padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;'>
                    
                    <!-- CVV -->
                    <label for='cvv' style='color: #555;'>CVV:</label>
                    <input type='text' id='cvv' name='cvv' required 
                        style='padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; width: 80px;'>
                    
                    <!-- Hidden Amount -->
                    <input type='hidden' name='totalAmount' value='$totalAmount'> <!-- Final amount after taxes -->
                    
                    <!-- Submit Button -->
                    <button type='submit' style='padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;'>
                        Pay \$$totalAmount
                    </button>
                </form>
            </div>
        </div>";
    }
}

?>
