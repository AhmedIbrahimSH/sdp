<?php

namespace DonationModule\Views;

class InvoiceView
{
    public function render($generatedInvoice)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice</title>
            <style>
                /* Global Styles */
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f9f9f9;
                    color: #333;
                }

                /* Invoice Container */
                .invoice-container {
                    max-width: 800px;
                    margin: 50px auto;
                    padding: 30px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }

                /* Invoice Header */
                .invoice-header {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .invoice-header h1 {
                    font-size: 2.5em;
                    color: #4CAF50;
                    margin: 0;
                }

                .invoice-header p {
                    font-size: 1.1em;
                    color: #666;
                }

                /* Invoice Details */
                .invoice-details {
                    margin-top: 20px;
                }

                .invoice-details p {
                    font-size: 1.2em;
                    margin: 10px 0;
                    padding: 10px;
                    background-color: #f4f4f4;
                    border-radius: 5px;
                }

                /* Footer */
                .invoice-footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 0.9em;
                    color: #777;
                }

                .invoice-footer a {
                    color: #4CAF50;
                    text-decoration: none;
                }

                .invoice-footer a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
        <div class="invoice-container">
            <div class="invoice-header">
                <h1>Invoice</h1>
                <p>Thank you for your transaction!</p>
            </div>
            <div class="invoice-details">
                <p><strong>Invoice Summary:</strong></p>
                <p><?= $generatedInvoice ?></p>
            </div>

        </div>
        </body>
        </html>
        <?php
    }
}

?>
