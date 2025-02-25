<?php

namespace App\Domain\Bus;

use App\Domain\DTO\StudentsGradeDTO;

interface StudentsGradeBusInterface
{
    public function studentsGrade(StudentsGradeDTO $studentsGradeDTO): bool;
}
