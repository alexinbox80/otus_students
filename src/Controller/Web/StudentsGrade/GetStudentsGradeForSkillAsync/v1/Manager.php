<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkillAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForSkillAsync\v1\Output\StudentsGradeAsyncDTO;;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;
use App\Domain\ValueObject\StudentGradeEnum;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService
    ) {
    }

    public function getStudentGradeForSkillAsync(): StudentsGradeAsyncDTO
    {
        $students = $this->studentService->findAll();
        foreach ($students as $student) {
            $completedTasks = $student->getCompletedTasks();
            foreach ($completedTasks as $completedTask) {
                $percentages = $completedTask->getTask()->getPercentages();
                foreach ($percentages as $percentage) {
                    $this->studentGradeService->getTotalGradeAsync(
                        $student->getId(),
                        StudentGradeEnum::GET_STUDENT_GRADE_FOR_SKILL->value,
                        $percentage->getSkill()->getId()
                    );
                }
            }
        }

        return new StudentsGradeAsyncDTO();
    }
}
