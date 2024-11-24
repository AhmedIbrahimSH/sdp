<?php

namespace Views;
class DonationTypesView
{
    // Method to render the donation type selection view
    public function renderDonationTypeSelection()
    {
        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Select Donation Type</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #e8f0fe;
                    margin: 0;
                    font-family: 'Arial', sans-serif;
                }
                .container {
                    text-align: center;
                    padding: 30px;
                    background-color: white;
                    border-radius: 15px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    width: 90%;
                }
                .container h1 {
                    margin-bottom: 30px;
                    color: #2c3e50;
                    font-size: 28px;
                }
                .buttons {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    gap: 20px;
                }
                .button {
                    background-color: #3498db;
                    color: white;
                    font-size: 18px;
                    font-weight: bold;
                    padding: 15px 20px;
                    border: none;
                    border-radius: 10px;
                    cursor: pointer;
                    text-align: center;
                    text-decoration: none;
                    width: 200px;
                    height: 70px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    transition: transform 0.2s ease, background-color 0.3s ease;
                    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
                }
                .button:hover {
                    background-color: #2980b9;
                    transform: translateY(-5px);
                }
                .button:active {
                    transform: translateY(0);
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
