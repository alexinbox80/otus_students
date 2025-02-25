<?php

namespace App\Domain\DTO;

use DateTime;

class StudentsGradeDTO
{
    public function __construct(
        public readonly int $studentId,
        public readonly ?int $entityId,
        public readonly ?DateTime $startDate,
        public readonly ?DateTime $endDate,
        public readonly string $typeStudentsGrade
    ) {
    }
}
