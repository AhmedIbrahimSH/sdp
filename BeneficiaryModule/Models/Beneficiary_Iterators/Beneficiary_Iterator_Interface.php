<?php
require_once __DIR__ . '/../Beneficiary.php';
interface BeneficiaryIterator
{
    public function hasNext(): bool;
    public function next(): ?Beneficiary;
}
