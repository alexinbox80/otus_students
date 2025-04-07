<?php

namespace App\Domain\Event\Customer;

class DeleteStudentEvent
{
    public function __construct(
        public readonly int $studentId,
        public readonly string $studentOid,
    ) {
    }
}
