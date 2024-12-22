<?php

namespace App\Domain\Service;

use App\Domain\Entity\Course;
use App\Infrastructure\Repository\CourseRepository;

class CourseService
{
    public function __construct(
        private readonly CourseRepository $courseRepository
    )
    {
    }

    /**
     * @param int $courseId
     * @return Course
     */
    public function find(int $courseId): Course
    {
        return $this->courseRepository->find($courseId);
    }

    /**
     * @param string $name
     * @return Course[]
     */
    public function findCourseByName(string $name): array
    {
        return $this->courseRepository->findCoursesByNameWithCriteria($name);
    }

    /**
     * @param string $name
     * @param string $description
     * @return Course
     */
    public function create(string $name, string $description): Course
    {
        $course = new Course();
        $course->setName($name);
        $course->setDescription($description);
        $this->courseRepository->create($course);

        return $course;
    }

    /**
     * @param int $courseId
     * @return void
     */
    public function removeById(int $courseId): void
    {
        $course = $this->courseRepository->find($courseId);
        if ($course instanceof Course) {
            $this->courseRepository->remove($course);
        }
    }
}
