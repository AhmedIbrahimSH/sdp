<?php

namespace Views;
class BankTransferPaymentView
{
    public function render()
    {
        echo "
        <h2>Bank Transfer Payment</h2>
        <form method='POST' action='?action=confirmBankTransferPayment'>
            <label>Bank Account:</label>
            <input type='text' name='bankAccount' required>
            <label>Transfer Amount:</label>
            <input type='text' name='transferAmount' required>
            <button type='submit'>Pay</button>
        </form>";
    }
}