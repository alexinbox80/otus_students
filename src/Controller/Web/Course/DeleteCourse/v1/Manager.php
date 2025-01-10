<?php

namespace App\Controller\Web\Course\DeleteCourse\v1;

use App\Controller\Web\Course\DeleteCourse\v1\Output\DeletedCourseDTO;
use App\Domain\Entity\Course;
use App\Domain\Service\CourseService;

class Manager
{
    public function __construct(
        private readonly CourseService $courseService
    ) {
    }

    public function deleteCourse(Course $course): DeletedCourseDTO
    {
        $this->courseService->removeCourse($course);
        return new DeletedCourseDTO();
    }
}
