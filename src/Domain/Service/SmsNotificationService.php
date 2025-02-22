<?php

namespace App\Domain\Service;

use App\Domain\Entity\SmsNotification;
use App\Infrastructure\Repository\SmsNotificationRepository;

class SmsNotificationService
{
    public function __construct(
        private readonly SmsNotificationRepository $emailNotificationRepository
    ) {
    }

    public function saveSmsNotification(string $phone, string $text, string $description, string $userId, string $entityName): void
    {
        $emailNotification = new SmsNotification(
            $userId,
            $phone,
            $text,
            $description,
            $entityName
        );

        $this->emailNotificationRepository->create($emailNotification);
    }
}
