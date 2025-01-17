<?php
require_once 'Need_Iterator_Interface.php';
class AllocationStatusIterator implements NeedIterator
{
    private $needs;
    private $position = 0;

    public function __construct(array $needs)
    {
        // Sort needs based on allocation status:
        // 1. Not allocated or not accepted
        // 2. Accepted but not allocated
        // 3. Allocated
        $this->needs = $this->sortNeedsByAllocationStatus($needs);
    }

    private function sortNeedsByAllocationStatus(array $needs): array
    {
        usort($needs, function ($a, $b) {
            // Priority 1: Not allocated or not accepted
            if (!$a->isAllocated() && !$a->isAccepted()) return -1;
            if (!$b->isAllocated() && !$b->isAccepted()) return 1;

            // Priority 2: Accepted but not allocated
            if ($a->isAccepted() && !$a->isAllocated()) return -1;
            if ($b->isAccepted() && !$b->isAllocated()) return 1;

            // Priority 3: Allocated
            return 0;
        });

        return $needs;
    }

    public function hasNext(): bool
    {
        return $this->position < count($this->needs);
    }

    public function next(): ?NeedTemplateMethod
    {
        if ($this->hasNext()) {
            $need = $this->needs[$this->position];
            $this->position++;
            return $need;
        }
        return null;
    }
}
