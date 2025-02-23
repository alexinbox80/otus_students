<?php

namespace App\Controller\Amqp\SendEmailNotification;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\SendEmailNotification\Input\Message;
use App\Domain\Service\EmailNotificationService;
use App\Domain\Service\StudentService;
use App\Domain\Service\TeacherService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly TeacherService $teacherService,
        private readonly EmailNotificationService $emailNotificationService,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        if ($message->entityName === 'Student' ) {
            $user = $this->studentService->find($message->userId);

            if ($user === null) {
                return $this->reject(sprintf('Student ID %s was not found or does not use email ', $message->userId));
            }
        }

        if ($message->entityName === 'Teacher' ) {
            $user = $this->teacherService->find($message->userId);

            if ($user === null) {
                return $this->reject(sprintf('Teacher ID %s was not found or does not use email ', $message->userId));
            }
        }

        if ($message->entityName === 'CompletedTask' ) {
            $user = $this->studentService->find($message->userId);

            if ($user === null) {
                return $this->reject(sprintf('Student ID %s was not found or does not use email ', $message->userId));
            }
        }

        $this->emailNotificationService->saveEmailNotification(
            $user->getEmail(),
            $message->text,
            $message->description,
            $message->userId,
            $message->entityName
        );

        return self::MSG_ACK;
    }
}
