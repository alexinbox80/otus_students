<?php

namespace App\Domain\Service;

use App\Domain\Entity\EmailNotification;
use App\Infrastructure\Repository\EmailNotificationRepository;

class EmailNotificationService
{
    public function __construct(
        private readonly EmailNotificationRepository $emailNotificationRepository
    ) {
    }

    public function saveEmailNotification(string $email, string $text, string $description, string $entityName): void
    {
        $emailNotification = new EmailNotification(
            $email,
            $text,
            $description,
            $entityName
        );

        $this->emailNotificationRepository->create($emailNotification);
    }
}
