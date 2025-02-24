<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Input\TimeRangeDTO;
use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService
    ) {
    }

    public function getStudentGradeForLessonInTimeRange(TimeRangeDTO $timeRangeDTO): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $totalGrade[] = [
                'id' => $student->getId(),
                'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                'lessonName' => '',
                'totalGrade' => $this->studentGradeService->getTotalGradeInTimeRange($timeRangeDTO->startDate, $timeRangeDTO->endDate, $student)
            ];
        }

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