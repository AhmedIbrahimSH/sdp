<?php
namespace app;

use app\Notifier;

class BaseNotification implements Notifier
{
    public function notify(string $message): void
    {
        // Basic notification logic, e.g., logging or console output
        echo "Base notification: $message<br>";
    }
}