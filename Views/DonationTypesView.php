<?php

class DonationTypesView
{
    // Method to render the donation type selection view
    public function renderDonationTypeSelection()
    {
        return "
        <html>
        <head>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f4f4f9;
                    margin: 0;
                }
                .container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .buttons {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    gap: 20px;
                }
                .button {
                    background-color: #007bff;
                    color: white;
                    font-size: 20px;
                    padding: 15px 30px;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    text-align: center;
                    text-decoration: none;
                    width: 200px;
                    height: 80px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    transition: background-color 0.3s;
                }
                .button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Select Donation Type</h1>
                <div class='buttons'>
                    <a href='?action=cashDonation' class='button'>Cash Donation</a>
                    <a href='?action=foodDonation' class='button'>Food Donation</a>
                    <a href='?action=drugsDonation' class='button'>Drugs Donation</a>
                    <a href='?action=clothesDonation' class='button'>Clothes Donation</a>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
