<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1\Input\TimeRangeDTO;
use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1\Output\StudentsGradeAsyncDTO;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;
use App\Domain\ValueObject\StudentGradeEnum;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService
    )
    {
    }

    public function getStudentGradeForLessonInTimeRangeAsync(TimeRangeDTO $timeRangeDTO): StudentsGradeAsyncDTO
    {
        $students = $this->studentService->findAll();

        foreach ($students as $student) {
            $this->studentGradeService->getTotalGradeAsync(
                $student->getId(),
                StudentGradeEnum::GET_STUDENT_GRADE_IN_TIME_RANGE->value,
                null,
                $timeRangeDTO->startDate,
                $timeRangeDTO->endDate
            );
        }

        return new StudentsGradeAsyncDTO();
    }
}