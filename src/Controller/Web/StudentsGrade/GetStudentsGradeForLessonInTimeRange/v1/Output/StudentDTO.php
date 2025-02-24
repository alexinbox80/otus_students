<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Output;

class StudentDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $studentName,
        public readonly string $lessonName,
        public readonly float $grade
    ) {
    }
}
