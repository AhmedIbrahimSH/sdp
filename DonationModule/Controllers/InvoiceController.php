<?php

namespace DonationModule\Controllers;

use DonationModule\Models\Decorator\InvoiceDetails;
use DonationModule\Models\Decorator\TransactionFeesDecorator;
use DonationModule\Models\Decorator\VATDecorator;
use DonationModule\Views\InvoiceView;

require_once 'DonationModule/Models/Decorator/InvoiceDetails.php';
require_once 'DonationModule/Models/Decorator/VATDecorator.php';
require_once 'DonationModule/Models/Decorator/TransactionFeesDecorator.php';
require_once 'DonationModule/Views/InvoiceView.php';

class InvoiceController
{

    public function showInvoice($invoiceID)
    {
        $lineTotal = 500;


        $baseInvoice = new InvoiceDetails($lineTotal);

        $vatRate = 10;
        $invoiceWithVAT = new VATDecorator($baseInvoice, $vatRate);

        $transactionFee = 15;
        $finalInvoice = new TransactionFeesDecorator($invoiceWithVAT, $transactionFee);


        $generatedInvoice = $finalInvoice->generate();



        $invoiceView = new InvoiceView();
        $invoiceView->render($generatedInvoice);

    }
}

?>
