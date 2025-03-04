<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-students-grade-for-skill',
        name: 'web_get_students_by_grade_for_skill_v1_invoke',
        methods: ['GET']
    )]
    public function __invoke(): array
    {
        return [
            'grade-for-skill' => $this->manager->getStudentGradeForSkill()
        ];
    }
}
