<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
    )
    {
    }

    public function getStudentGradeForLesson(): array
    {
        $totalGrade = $this->studentGradeService->getStudentGradeForLesson();

        return array_map(
            static fn(array $totalGrade) => (new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['lessonName'],
                $totalGrade['totalGrade'],
            ))->Output(),
            $totalGrade
        );
    }
}
