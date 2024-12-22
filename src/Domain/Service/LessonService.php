<?php

namespace App\Domain\Service;

use App\Domain\Entity\Lesson;
use App\Infrastructure\Repository\LessonRepository;

class LessonService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository
    )
    {
    }

    /**
     * @param int $lessonId
     * @return Lesson
     */
    public function find(int $lessonId): Lesson
    {
        return $this->lessonRepository->find($lessonId);
    }

    /**
     * @return Lesson[]
     */
    public function findAll(): array
    {
        return $this->lessonRepository->findAll();
    }

    /**
     * @param string $name
     * @return Lesson[]
     */
    public function findLessonsByName(string $name): array
    {
        return $this->lessonRepository->findLessonsByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return Lesson[]
     */
    public function findLessonsByDescription(string $description): array
    {
        return $this->lessonRepository->findLessonsByDescriptionWithCriteria($description);
    }

    /**
     * @param int $lessonId
     * @param string $name
     * @return Lesson|null
     */
    public function updateName(int $lessonId, string $name): ?Lesson
    {
        $lesson = $this->lessonRepository->find($lessonId);
        if (!($lesson instanceof Lesson)) {
            return null;
        }
        $this->lessonRepository->updateName($lesson, $name);

        return $lesson;
    }

    /**
     * @param int $lessonId
     * @param string $description
     * @return Lesson|null
     */
    public function updateDescription(int $lessonId, string $description): ?Lesson
    {
        $lesson = $this->lessonRepository->find($lessonId);
        if (!($lesson instanceof Lesson)) {
            return null;
        }
        $this->lessonRepository->updateDescription($lesson, $description);

        return $lesson;
    }

    /**
     * @param string $name
     * @param string $description
     * @return Lesson
     */
    public function create(string $name, string $description): Lesson
    {
        $lesson = new Lesson();
        $lesson->setName($name);
        $lesson->setDescription($description);
        $this->lessonRepository->create($lesson);

        return $lesson;
    }

    /**
     * @param int $lessonId
     * @return void
     */
    public function removeById(int $lessonId): void
    {
        $lesson = $this->lessonRepository->find($lessonId);
        if ($lesson instanceof Lesson) {
            $this->lessonRepository->remove($lesson);
        }
    }
}
