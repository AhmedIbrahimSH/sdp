<?php

namespace DonationModule\Models\Decorator;

require_once 'Invoice.php';

abstract class InvoiceDecorator extends Invoice
{
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    abstract public function generate();
}