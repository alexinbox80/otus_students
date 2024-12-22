<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lesson;
use Doctrine\Common\Collections\Criteria;

class LessonRepository extends AbstractRepository
{
    /**
     * @param int $lessonId
     * @return Lesson|null
     */
    public function find(int $lessonId): ?Lesson
    {
        $repository = $this->entityManager->getRepository(Lesson::class);
        /** @var Lesson|null $lesson */
        $lesson = $repository->find($lessonId);

        return $lesson;
    }

    /**
     * @return Lesson[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Lesson::class)->findAll();
    }

    /**
     * @param string $name
     * @return Lesson[]
     */
    public function findLessonsByName(string $name): array
    {
        return $this->entityManager->getRepository(Lesson::class)->findBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Lesson[]
     */
    public function findLessonsByNameWithCriteria(string $name): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('name', $name));
        $repository = $this->entityManager->getRepository(Lesson::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param string $description
     * @return Lesson[]
     */
    public function findLessonsByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Lesson::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Lesson $lesson
     * @param string $name
     * @return void
     */
    public function updateName(Lesson $lesson, string $name): void
    {
        $lesson->setName($name);
        $this->flush();
    }

    /**
     * @param Lesson $lesson
     * @param string $description
     * @return void
     */
    public function updateDescription(Lesson $lesson, string $description): void
    {
        $lesson->setDescription($description);
        $this->flush();
    }

    /**
     * @param Lesson $lesson
     * @return int
     */
    public function create(Lesson $lesson): int
    {
        return $this->store($lesson);
    }

    /**
     * @param Lesson $lesson
     * @return void
     */
    public function remove(Lesson $lesson): void
    {
        $lesson->setDeletedAt();
        $this->flush();
    }
}
