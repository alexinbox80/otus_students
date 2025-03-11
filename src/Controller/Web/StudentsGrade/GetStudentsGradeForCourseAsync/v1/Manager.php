<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForCourseAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForCourseAsync\v1\Output\StudentsGradeAsyncDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
    ) {
    }

    public function getStudentGradeForCourseAsync(): StudentsGradeAsyncDTO
    {
        $this->studentGradeService->getStudentGradeForCourseAsync();
        
        return new StudentsGradeAsyncDTO();
    }
}
