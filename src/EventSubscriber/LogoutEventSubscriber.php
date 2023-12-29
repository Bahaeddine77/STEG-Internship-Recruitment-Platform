<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    public function onLogout($event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'logout' => 'onLogout',
        ];
    }
}
