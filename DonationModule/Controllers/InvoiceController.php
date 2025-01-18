<?php

namespace Controllers;

use Models\Decorator\InvoiceDetails;
use Models\Decorator\TransactionFeesDecorator;
use Models\Decorator\VATDecorator;
use Views\InvoiceView;
use Exception;

require_once 'Models/Decorator/InvoiceDetails.php';
require_once 'Models/Decorator/VATDecorator.php';
require_once 'Models/Decorator/TransactionFeesDecorator.php';
require_once 'Views/InvoiceView.php';

class InvoiceController
{

    public function showInvoice($invoiceID)
    {
        // Example Line Total
        $lineTotal = 500; // Replace this with data from your database or logic

        // Create Base Invoice
        $baseInvoice = new InvoiceDetails($lineTotal);

        // Apply VAT Decorator
        $vatRate = 10; // 10% VAT
        $invoiceWithVAT = new VATDecorator($baseInvoice, $vatRate);
        // Apply Transaction Fees Decorator
        $transactionFee = 15; // Fixed fee
        $finalInvoice = new TransactionFeesDecorator($invoiceWithVAT, $transactionFee);

        // Generate Final Invoice String
        $generatedInvoice = $finalInvoice->generate();


        // Render the View
        $invoiceView = new InvoiceView();
        $invoiceView->render($generatedInvoice);
    }
}
