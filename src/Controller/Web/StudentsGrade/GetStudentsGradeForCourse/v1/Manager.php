<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService
    ) {
    }

    public function getStudentGradeForCourse(): array
    {
        $totalGrade = $this->studentGradeService->getStudentGradeForCourse();

        return array_map(
            static fn (array $totalGrade) => new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['courseName'],
                $totalGrade['totalGrade'],
            ),
            $totalGrade
        );
    }
}
