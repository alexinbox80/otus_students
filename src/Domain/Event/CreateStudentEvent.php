<?php

namespace App\Domain\Event;

class CreateStudentEvent
{
    public function __construct(
        public readonly int $studentId,
        public readonly int $userId,
        public readonly ?string $emailCode,
        public readonly ?string $phoneCode
    ) {
    }
}
