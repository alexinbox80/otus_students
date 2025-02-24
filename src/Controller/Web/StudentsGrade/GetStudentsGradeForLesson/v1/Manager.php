<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1\Output\StudentDTO;
use App\Domain\Service\CompletedTaskService;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService,
        private readonly CompletedTaskService $completedTaskService
    )
    {
    }

    public function getStudentGradeForLesson(): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $totalGrade[] = [
                    'id' => $student->getId(),
                    'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                    'lessonName' => $completedTask->getTask()->getLesson()->getName(),
                    'totalGrade' => $this->studentGradeService->getTotalGradeForLesson($completedTask->getTask()->getLesson(), $student)
                ];
            }
        }

        return array_map(
            static fn(array $totalGrade) => (new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['lessonName'],
                $totalGrade['totalGrade'],
            ))->Output(),
            $totalGrade
        );
    }
}
