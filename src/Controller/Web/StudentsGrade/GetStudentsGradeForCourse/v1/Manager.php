<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1\Output\StudentDTO;
use App\Domain\Service\CompletedTaskService;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService,
        private readonly CompletedTaskService $completedTaskService
    ) {
    }

    public function getStudentGradeForCourse(): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $totalGrade[] = [
                    'id' => $student->getId(),
                    'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                    'courseName' => $completedTask->getTask()->getLesson()->getCourse()->getName(),
                    'totalGrade' => $this->studentGradeService->getTotalGradeForCourse($completedTask->getTask()->getLesson()->getCourse(), $student)
                ];
            }
        }

        return array_map(
            static fn (array $totalGrade) => new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['courseName'],
                $totalGrade['totalGrade'],
            ),
            $totalGrade
        );
    }
}