<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Bus\SendNotificationBusInterface;
use App\Domain\Event\CreateTeacherEvent;
use App\Domain\Service\TeacherService;
use App\Domain\DTO\SendNotificationDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeacherEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly TeacherService $teacherService,
        private readonly SendNotificationBusInterface $sendNotificationBus
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreateTeacherEvent::class => 'onCreateTeacher'
        ];
    }

    public function onCreateTeacher(CreateTeacherEvent $event): void
    {
        $teacher = $this->teacherService->find($event->teacherId);

        $text = "Teacher {$teacher->getFirstName()} {$teacher->getLastName()} has been successfully created!\\n";

        if (!empty($event->emailCode)) {
            $description = "Confirmation code for email is {$event->emailCode}\\n";
            $this->sendNotificationBus->sendNotification(
                new SendNotificationDTO(
                    $event->teacherId,
                    $text,
                    $description,
                    'Teacher',
                    'email'
                )
            );
        }

        if (!empty($event->phoneCode)) {
            $description = "Confirmation code for phone is {$event->phoneCode}\\n";
            $this->sendNotificationBus->sendNotification(
                new SendNotificationDTO(
                    $event->teacherId,
                    $text,
                    $description,
                    'Teacher',
                    'sms'
                )
            );
        }
    }
}
