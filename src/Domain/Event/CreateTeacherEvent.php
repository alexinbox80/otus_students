<?php

namespace App\Domain\Event;

class CreateTeacherEvent
{
    public function __construct(
        public readonly int $teacherId,
        public readonly int $userId,
        public readonly ?string $emailCode,
        public readonly ?string $phoneCode
    ) {
    }
}
