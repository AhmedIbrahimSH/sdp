<?php

namespace Views;

class DonationCartView
{
    public function render()
    {
        session_start(); // Ensure session is started to access cart data

        echo "<div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>";
        echo "<h2 style='text-align: center; color: #333; font-weight: bold;'>Donation Cart</h2>";

        if (!isset($_SESSION['donation_cart']) || empty($_SESSION['donation_cart'])) {
            echo "<p style='text-align: center; font-size: 16px; color: #555;'>Your cart is empty.</p>";
        } else {
            echo "<ul style='list-style-type: none; padding: 0;'>";

            foreach ($_SESSION['donation_cart'] as $index => $donation) {
                echo "<li style='padding: 10px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;'>
                        <span style='font-size: 16px; color: #333;'>$donation</span>
                        <form method='POST' action='?action=removeFromCart' style='margin: 0;'>
                            <input type='hidden' name='index' value='$index'>
                            <button type='submit' style='background-color: #ff6f61; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Remove</button>
                        </form>
                      </li>";
            }

            echo "</ul>";

            echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>
                    <a href='?action=proceedToPayment' style='background-color: #28a745; color: white; padding: 10px; border-radius: 4px; text-decoration: none; text-align: center;'>Proceed to Payment</a>
                    <a href='index.php' style='background-color: #007bff; color: white; padding: 10px; border-radius: 4px; text-decoration: none; text-align: center;'>Continue Donating</a>
                  </div>";
        }

        echo "</div>";
    }
}
