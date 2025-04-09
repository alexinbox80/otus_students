<?php

namespace App\Domain\Event\Customer;

class CreateStudentEvent
{
    public function __construct(
        public readonly int $studentId,
        public readonly string $studentOid,
    ) {
    }
}
