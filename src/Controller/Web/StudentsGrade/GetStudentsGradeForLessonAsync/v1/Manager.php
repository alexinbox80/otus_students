<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonAsync\v1\Output\StudentsGradeAsyncDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
    )
    {
    }

    public function getStudentGradeForLessonAsync(): StudentsGradeAsyncDTO
    {
        $this->studentGradeService->getStudentGradeForLessonAsync();

        return new StudentsGradeAsyncDTO();
    }
}
