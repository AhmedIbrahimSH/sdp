<?php
namespace app;

use app\Notifier;

abstract class DecoratorNotification implements Notifier
{
    protected $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function notify(string $message): void
    {
        $this->notifier->notify($message);
    }
}
