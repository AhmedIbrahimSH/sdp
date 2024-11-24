<?php

namespace Views;
class AddFoodDonationView
{
    public function render($predefinedAmount)
    {
        $html = "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
            <h2 style='text-align: center; color: #333; font-weight: bold;'>Add Food Donation</h2>
            <p style='font-size: 16px; color: #555; text-align: center;'>
                Price per item: <strong>\$$predefinedAmount</strong>
            </p>
            <form method='POST' action='?action=proceedToPayment' style='display: flex; flex-direction: column; gap: 15px; align-items: center;'>

                <!-- Quantity Field -->
                <div style='display: flex; align-items: center; gap: 10px;'>
                    <label for='quantity' style='font-size: 16px; color: #555;'>Quantity:</label>
                    <button 
                        type='button' 
                        onclick='decreaseQuantity()' 
                        style='background-color: #ff6f61; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'
                        aria-label='Decrease quantity'
                    >
                        -
                    </button>
                    <input 
                        type='number' 
                        id='quantity' 
                        name='Data' 
                        value='1' 
                        readonly 
                        style='padding: 10px; width: 80px; text-align: center; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;'
                        aria-label='Quantity input field'
                    >
                    <button 
                        type='button' 
                        onclick='increaseQuantity()' 
                        style='background-color: #007bff; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'
                        aria-label='Increase quantity'
                    >
                        +
                    </button>
                </div>

                <!-- Proceed Button -->
                <button 
                    type='submit' 
                    style='background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;'
                >
                    Proceed to Payment
                </button>
            </form>
        </div>
        <script>
            // JavaScript to Handle Quantity Increment and Decrement
            let quantity = 1;

            function increaseQuantity() {
                quantity++;
                document.getElementById('quantity').value = quantity;
            }

            function decreaseQuantity() {
                if (quantity > 1) {
                    quantity--;
                    document.getElementById('quantity').value = quantity;
                }
            }
        </script>
        ";

        echo $html;
    }
}
