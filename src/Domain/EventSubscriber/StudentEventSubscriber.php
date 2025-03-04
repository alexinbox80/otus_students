<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Bus\SendNotificationBusInterface;
use App\Domain\Event\CreateStudentEvent;
use App\Domain\Service\StudentService;
use App\Domain\DTO\SendNotificationDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StudentEventSubscriber implements EventSubscriberInterface
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
            CreateStudentEvent::class => 'onCreateStudent'
        ];
    }

    public function onCreateStudent(CreateStudentEvent $event): void
    {
        $student = $this->studentService->find($event->studentId);

        $text = "Student {$student->getFirstName()} {$student->getLastName()} has been successfully created!\\n";

        if (!empty($event->emailCode)) {
            $description = "Confirmation code for email is {$event->emailCode}\\n";
            $this->sendNotificationBus->sendNotification(
                new SendNotificationDTO(
                    $event->studentId,
                    $text,
                    $description,
                    'Student',
                    'email'
                )
            );
        }

        if (!empty($event->phoneCode)) {
            $description = "Confirmation code for phone is {$event->phoneCode}\\n";
            $this->sendNotificationBus->sendNotification(
                new SendNotificationDTO(
                    $event->studentId,
                    $text,
                    $description,
                    'Student',
                    'sms'
                )
            );
        }
    }
}
