<?php

namespace App\Domain\Event\Customer;

class UpdateStudentEvent
{
    public function __construct(
        public readonly int $studentId,
        public readonly string $studentOid,
    ) {
    }
}
