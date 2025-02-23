<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Bus\SendNotificationBusInterface;
use App\Domain\Event\CompletedTaskEvent;
use App\Domain\Service\StudentService;
use App\Domain\DTO\SendNotificationDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompletedTaskEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly SendNotificationBusInterface $sendNotificationBus
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CompletedTaskEvent::class => 'onCompletedTask'
        ];
    }

    public function onCompletedTask(CompletedTaskEvent $event): void
    {
        $student = $this->studentService->find($event->createCompletedTaskModel->studentId);

        $text = "Dear {$student->getFirstName()} {$student->getLastName()}!,\\n you mark is {$event->createCompletedTaskModel->grade} for {$event->task->getName()} \\n";
        $description = "Completed task: {$event->task->getName()} Description: {$event->task->getDescription()}\\n";

        $this->sendNotificationBus->sendNotification(
            new SendNotificationDTO(
                $event->createCompletedTaskModel->studentId,
                $text,
                $description,
                'CompletedTask',
                'email'
            )
        );
    }
}
