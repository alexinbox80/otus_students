<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1\Output;

class StudentDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $studentName,
        public readonly string $lessonName,
        public readonly float $grade
    ) {
    }

    public function Output(): array
    {
        return [
            'id' => $this->id,
            'student-name' => $this->studentName,
            'lesson-name' => $this->lessonName,
            'grade' => $this->grade
        ];
    }
}
