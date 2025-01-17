<?php

namespace Views;

class DonationCartView
{
    public function render()
    {
        session_start(); // Ensure session is started

        echo "<div style='width: 50%; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;'>";
        echo "<h2 style='text-align: center; color: #333; font-weight: bold;'>Donation Cart</h2>";

        if (!isset($_SESSION['donation_cart']) || empty($_SESSION['donation_cart'])) {
            echo "<p style='text-align: center; font-size: 16px; color: #555;'>Your cart is empty.</p>";
        } else {
            echo "<ul style='list-style-type: none; padding: 0;'>";

            foreach ($_SESSION['donation_cart'] as $index => $donation) {
                // Check if donation is serialized and deserialize it
                if (is_string($donation)) {
                    $donation = unserialize($donation);
                }

                // Ensure donation is an array before accessing keys
                if (is_array($donation)) {
                    echo "<li style='padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;'>
                            <div>
                                <strong style='color: #333;'>Donation Type:</strong> {$donation['donationType']} <br>
                                <strong style='color: #333;'>Quantity:</strong> {$donation['quantity']} <br>
                                <strong style='color: #333;'>Price per Unit:</strong> \${$donation['pricePerUnit']} <br>
                                <strong style='color: #333;'>Total Amount:</strong> \${$donation['totalAmount']}
                            </div>
                            <form method='POST' action='?action=removeFromCart' style='margin: 0;'>
                                <input type='hidden' name='index' value='$index'>
                                <button type='submit' style='background-color: #ff6f61; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;'>Remove</button>
                            </form>
                          </li>";
                }
            }

            echo "</ul>";

            // Undo & Redo Buttons
            echo "<div style='display: flex; justify-content: center; gap: 15px; margin-top: 20px;'>
                    <form method='POST' action='?action=undoLastAction' style='margin: 0;'>
                        <button type='submit' style='background-color: #f39c12; color: white; padding: 10px 16px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;'>Undo</button>
                    </form>

                    <form method='POST' action='?action=redoLastAction' style='margin: 0;'>
                        <button type='submit' style='background-color: #8e44ad; color: white; padding: 10px 16px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;'>Redo</button>
                    </form>
                  </div>";

            echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>
                    <a href='?action=proceedToPayment' style='background-color: #28a745; color: white; padding: 12px 18px; border-radius: 5px; text-decoration: none; font-weight: bold;'>Proceed to Payment</a>
                    <a href='?action=addDonation' style='background-color: #007bff; color: white; padding: 12px 18px; border-radius: 5px; text-decoration: none; font-weight: bold;'>Continue Donating</a>
                  </div>";
        }

        echo "</div>";
    }
}
