<?php

namespace App\Domain\DTO;

class SendNotificationDTO
{
    public function __construct(
        public readonly int $studentId,
        public readonly string $text,
        public readonly string $description,
        public readonly string $entityName,
        public readonly string $route
    ) {
    }
}
