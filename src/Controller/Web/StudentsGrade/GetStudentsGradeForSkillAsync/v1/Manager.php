<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkillAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForSkillAsync\v1\Output\StudentsGradeAsyncDTO;;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
    ) {
    }

    public function getStudentGradeForSkillAsync(): StudentsGradeAsyncDTO
    {
        $this->studentGradeService->getStudentGradeForSkillAsync();

        return new StudentsGradeAsyncDTO();
    }
}
