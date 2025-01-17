<?php
require_once 'Beneficiary_Iterator_Interface.php';
class IncomeBasedIterator implements BeneficiaryIterator
{
    private $beneficiaries;
    private $position = 0;

    public function __construct(array $beneficiaries)
    {
        // Sort beneficiaries by income (least income first)
        usort($beneficiaries, function ($a, $b) {
            return $a->getIncome() - $b->getIncome();
        });

        $this->beneficiaries = $beneficiaries;
    }

    public function hasNext(): bool
    {
        return $this->position < count($this->beneficiaries);
    }

    public function next(): ?Beneficiary
    {
        if ($this->hasNext()) {
            $beneficiary = $this->beneficiaries[$this->position];
            $this->position++;
            return $beneficiary;
        }
        return null;
    }
}
