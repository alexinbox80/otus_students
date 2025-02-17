<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Bus\SendNotificationBusInterface;
use App\Domain\Event\CreateUserEvent;
use App\Domain\Service\UserService;
use App\Domain\DTO\SendNotificationDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserService $userService,
        private readonly SendNotificationBusInterface $sendNotificationBus
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreateUserEvent::class => 'onCreateUser'
        ];
    }

    public function onCreateUser(CreateUserEvent $event): void
    {
        $text = "User {$event->login} has been created!\\n";
        $description = "Confirmation code is {$event->activationCode}\\n";
        $this->sendNotificationBus->sendNotification(
            new SendNotificationDTO(
                rand(1, 3),
                $text,
                $description,
                'User'
            )
        );
    }
}
