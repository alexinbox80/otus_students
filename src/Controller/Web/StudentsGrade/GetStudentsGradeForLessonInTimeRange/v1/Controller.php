<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-students-grade-for-lesson-in-time-range',
        name: 'web_get_students_by_grade_for_lesson_in_time_range_v1_invoke',
        methods: ['GET']
    )]
    public function __invoke(): array
    {
        return [
            'grade-for-lesson-in-time-range' => $this->manager->getStudentGradeForLessonInTimeRange()
        ];
    }
}