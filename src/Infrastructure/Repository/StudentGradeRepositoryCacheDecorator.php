<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Repository\StudentGradeRepositoryInterface;
use App\Domain\ValueObject\RedisCacheTagEnum;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use DateTime;

class StudentGradeRepositoryCacheDecorator implements StudentGradeRepositoryInterface
{
    public function __construct(
        private readonly StudentGradeRepository $studentGradeRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function ClearCache(): void
    {
        $this->cache->invalidateTags([
            RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_LESSON->value,
            RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_SKILL->value,
            RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_COURSE->value,
            RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_IN_TIME_RANGE->value
        ]);
    }

    /**
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     * @throws InvalidArgumentException
     */
    public function getTotalGradeForLesson(Lesson $lesson, Student $student): float
    {
        return $this->cache->get(
            $this->getCacheKey(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_LESSON->value, $lesson->getId(), $student->getId()),
            function (ItemInterface $item) use ($lesson, $student) {
                $totalGrade = $this->studentGradeRepository->getTotalGradeForLessonWithCriteria($lesson, $student);
                $item->set($totalGrade);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_LESSON->value);

                return $totalGrade;
            }
        );
    }

    /**
     * @param Skill $skill
     * @param Student $student
     * @return float
     * @throws InvalidArgumentException
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float
    {
        return $this->cache->get(
            $this->getCacheKey(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_SKILL->value, $skill->getId(), $student->getId()),
            function (ItemInterface $item) use ($skill, $student) {
                $totalGrade = $this->studentGradeRepository->getTotalGradeForSkill($skill, $student);
                $item->set($totalGrade);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_SKILL->value);

                return $totalGrade;
            }
        );
    }

    /**
     * @param Course $course
     * @param Student $student
     * @return float
     * @throws InvalidArgumentException
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float
    {
        return $this->cache->get(
            $this->getCacheKey(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_COURSE->value, $course->getId(), $student->getId()),
            function (ItemInterface $item) use ($course, $student) {
                $totalGrade = $this->studentGradeRepository->getTotalGradeForCourse($course, $student);
                $item->set($totalGrade);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_FOR_COURSE->value);

                return $totalGrade;
            }
        );
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     * @throws InvalidArgumentException
     */
    public function getTotalGradeInTimeRange(DateTime $startDate, DateTime $endDate, Student $student): float
    {
        return $this->cache->get(
            $this->getCacheKey(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_IN_TIME_RANGE->value, -1, $student->getId()),
            function (ItemInterface $item) use ($startDate, $endDate, $student) {
                $totalGrade = $this->studentGradeRepository->getTotalGradeInTimeRangeWithCriteria($startDate, $endDate, $student);
                $item->set($totalGrade);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_GET_TOTAL_GRADE_IN_TIME_RANGE->value);

                return $totalGrade;
            }
        );
    }

    /**
     * @param string $name
     * @param int $itemId
     * @param int $studentId
     * @return string
     */
    private function getCacheKey(string $name, int $itemId, int $studentId): string
    {
        return $name . "_{$itemId}_$studentId";
    }
}
