<?php
namespace app;

interface Notifier
{
    public function notify(string $message): void;
}