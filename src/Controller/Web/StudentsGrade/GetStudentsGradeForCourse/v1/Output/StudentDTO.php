<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1\Output;

class StudentDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $studentName,
        public readonly string $courseName,
        public readonly float $grade
    ) {
    }
}
