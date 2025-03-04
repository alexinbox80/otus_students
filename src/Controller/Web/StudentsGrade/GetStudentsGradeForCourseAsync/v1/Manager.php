<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForCourseAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForCourseAsync\v1\Output\StudentsGradeAsyncDTO;
use App\Domain\Service\CompletedTaskService;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;
use App\Domain\ValueObject\StudentGradeEnum;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService,
        private readonly CompletedTaskService $completedTaskService
    ) {
    }

    public function getStudentGradeForCourseAsync(): StudentsGradeAsyncDTO
    {
        $students = $this->studentService->findAll();

        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $this->studentGradeService->getTotalGradeAsync(
                    $student->getId(),
                    StudentGradeEnum::GET_STUDENT_GRADE_FOR_COURSE->value,
                    $completedTask->getTask()->getLesson()->getCourse()->getId(),
                );
            }
        }

        return new StudentsGradeAsyncDTO();
    }
}
