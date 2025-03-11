<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService
    ) {
    }

    public function getStudentGradeForSkill(): array
    {
        $totalGrade = $this->studentGradeService->getStudentGradeForSkill();

        return array_map(
            static fn (array $totalGrade) => new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['skillName'],
                $totalGrade['totalGrade'],
            ),
            $totalGrade
        );
    }
}
