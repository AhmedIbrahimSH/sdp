<?php
require_once __DIR__ . '/../Needs/NeedTemplateMethod.php';
interface NeedIterator
{
    public function hasNext(): bool;
    public function next(): ?NeedTemplateMethod;
}
