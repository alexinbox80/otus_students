<?php

namespace App\Controller\Amqp\SendSmsNotification;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\SendSmsNotification\Input\Message;
use App\Domain\Service\SmsNotificationService;
use App\Domain\Service\StudentService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly SmsNotificationService $smsNotificationService,
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
            return $this->reject(sprintf('Student ID %s was not found or does not use phone ', $message->userId));
        }

        $this->smsNotificationService->saveSmsNotification(
            $student->getPhone(),
            $message->text,
            $message->description,
            $message->entityName
        );

        return self::MSG_ACK;
    }
}
