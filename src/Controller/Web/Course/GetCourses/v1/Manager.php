<?php

namespace App\Controller\Web\Course\GetCourses\v1;

use App\Domain\Entity\Course;
use App\Domain\Service\CourseService;

class Manager
{
    public function __construct(private readonly CourseService $courseService)
    {
    }

    /**
     * @return Course[]
     */
    public function getCourses(?int $page, ?int $perPage): array
    {
        return $this->courseService->getCourses($page, $perPage);
    }
}
