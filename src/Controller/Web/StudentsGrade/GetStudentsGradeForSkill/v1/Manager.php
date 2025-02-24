<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1\Output\StudentDTO;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        private readonly StudentGradeService $studentGradeService,
        private readonly StudentService $studentService
    ) {
    }

    public function getStudentGradeForSkill(): array
    {
        $students = $this->studentService->findAll();
        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $student->getCompletedTasks();
            foreach ($completedTasks as $completedTask) {
                $percentages = $completedTask->getTask()->getPercentages();
                foreach ($percentages as $percentage) {
                    $totalGrade[] = [
                        'id' => $student->getId(),
                        'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                        'skillName' => $percentage->getSkill()->getName(),
                        'totalGrade' => $this->studentGradeService->getTotalGradeForSkill($percentage->getSkill(), $student)
                    ];
                }
            }
        }

        return array_map(
            static fn (array $totalGrade) => new StudentDTO(
                $totalGrade['id'],
                $totalGrade['userName'],
                $totalGrade['skillName'],
                $totalGrade['totalGrade'],
            ),
            $totalGrade
        );
    }
}
