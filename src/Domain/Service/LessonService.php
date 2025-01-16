<?php

namespace App\Domain\Service;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Model\CreateLessonModel;
use App\Domain\Model\UpdateLessonModel;
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
     * @return ?Lesson
     */
    public function find(int $lessonId): ?Lesson
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
     * @return Lesson[]
     */
    public function getLessons(int $page, int $perPage): array
    {
        return $this->lessonRepository->getLessons($page, $perPage);
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
     * @param Lesson $lesson
     * @param UpdateLessonModel $updateLessonModel
     * @return Lesson
     */
    public function update(Lesson $lesson, UpdateLessonModel $updateLessonModel): Lesson
    {
        $lesson->changeFields(
            $updateLessonModel->name,
            $updateLessonModel->description
        );

        $this->lessonRepository->update();

        return $lesson;
    }

    /**
     //* @param Course $course
     * @param CreateLessonModel $createLessonModel
     * @return Lesson
     */
    public function create(
      //  Course $course,
        CreateLessonModel $createLessonModel
    ): Lesson
    {
        $lesson = new Lesson(
            $createLessonModel->name,
            $createLessonModel->description
        );

       // $course->addLesson($lesson);

        $this->lessonRepository->create($lesson);

        return $lesson;
    }

    /**
     * @param Lesson $lesson
     * @param Course $course
     * @return Lesson
     */
    public function changeCourse(Lesson $lesson, Course $course): Lesson
    {
        $lesson->getCourse()->removeLesson($lesson);
        $lesson->removeCourse()->setCourse($course);
        $this->lessonRepository->update();

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

    /**
     * @param Lesson $lesson
     * @return void
     */
    public function removeLesson(Lesson $lesson): void
    {
        $this->lessonRepository->remove($lesson);
    }
}
