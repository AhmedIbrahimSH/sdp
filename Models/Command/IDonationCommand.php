<?php

namespace Models\Command;

interface IDonationCommand
{
    public function execute();
    public function undo();

}