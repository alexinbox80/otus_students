<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Course;
use Doctrine\Common\Collections\Criteria;

class CourseRepository extends AbstractRepository
{
    /**
     * @param int $courseId
     * @return Course|null
     */
    public function find(int $courseId): ?Course
    {
        $repository = $this->entityManager->getRepository(Course::class);
        /** @var Course|null $course */
        $course = $repository->find($courseId);

        return $course;
    }

    /**
     * @return Course[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Course::class)->findAll();
    }

    /**
     * @param string $name
     * @return Course[]
     */
    public function findCourseByName(string $name): array
    {
        return $this->entityManager->getRepository(Course::class)->findBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Course[]
     */
    public function findCoursesByNameWithCriteria(string $name): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('name', $name));
        $repository = $this->entityManager->getRepository(Course::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param string $description
     * @return Course[]
     */
    public function findCoursesByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Course::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Course $course
     * @param string $name
     * @return void
     */
    public function updateName(Course $course, string $name): void
    {
        $course->setName($name);
        $this->flush();
    }

    /**
     * @param Course $course
     * @param string $description
     * @return void
     */
    public function updateDescription(Course $course, string $description): void
    {
        $course->setDescription($description);
        $this->flush();
    }

    /**
     * @param Course $course
     * @return int
     */
    public function create(Course $course): int
    {
        return $this->store($course);
    }

    /**
     * @param Course $course
     * @return void
     */
    public function remove(Course $course): void
    {
        $course->setDeletedAt();
        $this->flush();
    }
}
