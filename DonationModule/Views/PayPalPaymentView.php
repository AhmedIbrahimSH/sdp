<?php

namespace DonationModule\Views;
class PayPalPaymentView
{
    public function render()
    {
        echo "
        <h2>PayPal Payment</h2>
        <form method='POST' action='?action=confirmPayPalPayment'>
            <label>Email:</label>
            <input type='email' name='email' required>
            <input type='hidden' name='amount' value='100'> <!-- Replace with actual amount -->
            <button type='submit'>Pay</button>
        </form>";
    }
}
