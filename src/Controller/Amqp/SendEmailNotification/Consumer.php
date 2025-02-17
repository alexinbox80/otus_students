<?php

namespace App\Controller\Amqp\SendEmailNotification;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\SendEmailNotification\Input\Message;
use App\Domain\Service\EmailNotificationService;
use App\Domain\Service\StudentService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly StudentService $studentService,
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
        $student = $this->studentService->find($message->userId);

        if ($student === null) {
            return $this->reject(sprintf('Student ID %s was not found or does not use email ', $message->userId));
        }

        $this->emailNotificationService->saveEmailNotification(
            $student->getEmail(),
            $message->text,
            $message->description,
            $message->entityName
        );

        return self::MSG_ACK;
    }
}
