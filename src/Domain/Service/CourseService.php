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
     * @return Course[]
     */
    public function findAll(): array
    {
        return $this->courseRepository->findAll();
    }

    /**
     * @param string $name
     * @return Course[]
     */
    public function findCoursesByName(string $name): array
    {
        return $this->courseRepository->findCoursesByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return Course[]
     */
    public function findCoursesByDescription(string $description): array
    {
        return $this->courseRepository->findCoursesByDescriptionWithCriteria($description);
    }

    /**
     * @param int $courseId
     * @param string $name
     * @return Course|null
     */
    public function updateName(int $courseId, string $name): ?Course
    {
        $course = $this->courseRepository->find($courseId);
        if (!($course instanceof Course)) {
            return null;
        }
        $this->courseRepository->updateName($course, $name);

        return $course;
    }

    /**
     * @param int $courseId
     * @param string $description
     * @return Course|null
     */
    public function updateDescription(int $courseId, string $description): ?Course
    {
        $course = $this->courseRepository->find($courseId);
        if (!($course instanceof Course)) {
            return null;
        }
        $this->courseRepository->updateDescription($course, $description);

        return $course;
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
