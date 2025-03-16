<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1\Input\TimeRangeDTO;
use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1\Output\StudentsGradeAsyncDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
    )
    {
    }

    public function getStudentGradeForLessonInTimeRangeAsync(TimeRangeDTO $timeRangeDTO): StudentsGradeAsyncDTO
    {
        $this->studentGradeService->getStudentGradeForLessonInTimeRangeAsync($timeRangeDTO->startDate, $timeRangeDTO->endDate);

        return new StudentsGradeAsyncDTO();
    }
}
