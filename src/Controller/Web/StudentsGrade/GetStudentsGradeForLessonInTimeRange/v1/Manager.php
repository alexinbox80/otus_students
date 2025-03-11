<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Input\TimeRangeDTO;
use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService
    ) {
    }

    public function getStudentGradeForLessonInTimeRange(TimeRangeDTO $timeRangeDTO): array
    {
        $totalGrade = $this->studentGradeService->getStudentGradeForLessonInTimeRange($timeRangeDTO->startDate, $timeRangeDTO->endDate);

        return array_map(
            static fn (array $totalGrade) => new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['lessonName'],
                $totalGrade['totalGrade'],
            ),
            $totalGrade
        );
    }
}
