<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1\Output;

class StudentDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $studentName,
        public readonly float $grade
    ) {
    }
}
