<?php

namespace Models\Decorator;

require_once 'InvoiceDecorator.php';

class VATDecorator extends InvoiceDecorator
{
    protected $invoice;
    private $vatRate;

    public function __construct(Invoice $invoice, $vatRate)
    {
        parent::__construct($invoice);
        $this->vatRate = $vatRate;
    }

    public function generate()
    {
        $originalInvoice = $this->invoice->generate();
        $vat = ($this->vatRate / 100) * $this->getLineTotal();
        return $originalInvoice . ", VAT: {$vat}";
    }

    private function getLineTotal()
    {
        preg_match('/Line Total: (\d+(\.\d+)?)/', $this->invoice->generate(), $matches);
        return floatval($matches[1]);
    }
}