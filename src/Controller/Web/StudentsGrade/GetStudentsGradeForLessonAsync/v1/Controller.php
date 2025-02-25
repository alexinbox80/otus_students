<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonAsync\v1;

use App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonAsync\v1\Output\StudentsGradeAsyncDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-students-grade-for-lesson-async',
        name: 'web_get_students_by_grade_for_lesson_async_v1_invoke',
        methods: ['GET']
    )]
    public function __invoke(): StudentsGradeAsyncDTO
    {
        return $this->manager->getStudentGradeForLessonAsync();
    }
}
