<?php

namespace App\Controller\Web\Course\GetCourseById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Course\GetCourseById\v1\Output\GotCourseByIdDTO;
use App\Domain\Service\CourseService;

class Manager
{
    public function __construct(private readonly CourseService $courseService)
    {
    }

    /**
     * @param int $courseId
     * @return GotCourseByIdDTO|EmptyDTO
     */
    public function find(int $courseId): GotCourseByIdDTO|EmptyDTO
    {
        $course = $this->courseService->find($courseId);

        if (!is_null($course)) {
            return new GotCourseByIdDTO(
                $course->getId(),
                $course->getName(),
                $course->getDescription(),
                $course->getCreatedAt()->format('Y-m-d H:i:s'),
                $course->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
