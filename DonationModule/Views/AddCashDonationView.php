<?php

namespace DonationModule\Views;

class AddCashDonationView
{
    public function render()
    {
        $html = "
        <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; padding-bottom: 20px;'>
            <h2 style='text-align: center; color: #333; font-weight: bold; margin-top: 20px;'>Add Cash Donation</h2>

            <form id='donationForm' style='display: flex; flex-direction: column; gap: 15px; align-items: center; padding: 20px;'>
                <label for='amount' style='font-size: 16px; color: #555;'>Donation Amount:</label>
                <input 
                    type='number' 
                    id='amount' 
                    name='predefinedAmount' 
                    step='0.01' 
                    placeholder='Enter amount' 
                    required 
                    style='padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; width: 50%; text-align: center;'
                >

                <!-- Buttons Container -->
                <div style='display: flex; gap: 15px; margin-top: 20px;'>
                    <button type='button' onclick='addToCart()' style='background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: bold;'>Add to Cart</button>
                    <a href='?action=showCart' style='background-color: #007bff; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; text-align: center; font-weight: bold;'>Show Cart</a>
                </div>
            </form>
        </div>

        <!-- Pop-up Message -->
        <div id='popupMessage' style='display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(40, 167, 69, 0.9); color: white; padding: 15px 25px; border-radius: 8px; text-align: center; font-size: 18px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-weight: bold;'>
            ✅ Cash donation added to cart!
        </div>

        <script>
            function addToCart() {
                let amount = document.getElementById('amount').value;

                if (amount <= 0) {
                    alert('Please enter a valid donation amount.');
                    return;
                }

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '?action=addToDonationCart', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        showPopup();
                    }
                };
                xhr.send('donationType=cashDonation&Data=1&predefinedAmount=' + encodeURIComponent(amount));
            }

            function showPopup() {
                let popup = document.getElementById('popupMessage');
                popup.style.display = 'block';

                setTimeout(function() {
                    popup.style.display = 'none';
                }, 1500);
            }
        </script>
        ";

        echo $html;
    }
}
