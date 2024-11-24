<?php

namespace Models\Decorator;

require_once 'InvoiceDecorator.php';

class TransactionFeesDecorator extends InvoiceDecorator
{
    protected $invoice;
    private $transactionFee;

    public function __construct(Invoice $invoice, $transactionFee)
    {
        parent::__construct($invoice);
        $this->transactionFee = $transactionFee;
    }

    public function generate()
    {
        $originalInvoice = $this->invoice->generate();
        return $originalInvoice . ", Transaction Fee: {$this->transactionFee}";
    }
}