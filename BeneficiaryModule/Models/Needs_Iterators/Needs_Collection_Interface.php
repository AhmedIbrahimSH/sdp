<?php
interface NeedsCollectionInterface
{
    public function getIterator(): NeedIterator;
}
