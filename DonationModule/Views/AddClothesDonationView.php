<?php

namespace DonationModule\Views;

class AddClothesDonationView
{
    public function render($donationType, $predefinedAmount)
    {
        $html = "
    <div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; padding-bottom: 20px;'>
        <h2 style='text-align: center; color: #333; font-weight: bold; margin-top: 20px;'>Add $donationType Donation</h2>
        <p style='font-size: 16px; color: #555; text-align: center;'>
            Price per item: <strong>\$$predefinedAmount</strong>
        </p>

        <form id='donationForm' style='display: flex; flex-direction: column; gap: 15px; align-items: center; padding: 20px;'>
            <!-- Hidden inputs for predefinedAmount and donationType -->
            <input type='hidden' id='pricePerUnit' value='$predefinedAmount'>
            <input type='hidden' id='donationType' value='$donationType'>

            <!-- Quantity Field -->
            <div style='display: flex; align-items: center; gap: 15px; background-color: #f9f9f9; padding: 10px; border-radius: 8px;'>
                <label for='quantity' style='font-size: 16px; color: #555;'>Quantity:</label>
                <button type='button' onclick='decreaseQuantity()' style='background-color: #ff6f61; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;'>-</button>
                <input type='number' id='quantity' name='Data' value='1' readonly style='padding: 10px; width: 60px; text-align: center; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;'>
                <button type='button' onclick='increaseQuantity()' style='background-color: #007bff; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;'>+</button>
            </div>

            <!-- Buttons Container -->
            <div style='display: flex; gap: 15px; margin-top: 20px;'>
                <button type='button' onclick='addToCart()' style='background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: bold;'>Add to Cart</button>
                <a href='?action=showCart' style='background-color: #007bff; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-size: 16px; text-align: center; font-weight: bold;'>Show Cart</a>
            </div>
        </form>
    </div>

    <!-- Pop-up Message -->
    <div id='popupMessage' style='display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(40, 167, 69, 0.9); color: white; padding: 15px 25px; border-radius: 8px; text-align: center; font-size: 18px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); font-weight: bold;'>
        ✅ Donation added to cart!
    </div>

    <script>
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

        function addToCart() {
            let quantityValue = document.getElementById('quantity').value;
            let pricePerUnit = document.getElementById('pricePerUnit').value; 
            let donationType = document.getElementById('donationType').value; 

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '?action=addToDonationCart', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showPopup();
                }
            };
            xhr.send('donationType=' + encodeURIComponent(donationType) + 
                     '&Data=' + encodeURIComponent(quantityValue) + 
                     '&predefinedAmount=' + encodeURIComponent(pricePerUnit));
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
