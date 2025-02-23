<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Repository\StudentGradeRepositoryInterface;
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
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLesson(Lesson $lesson, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForLessonWithCriteria($lesson, $student);
    }

    /**
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForSkillWithCriteria($skill, $student);
    }

    /**
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForCourseWithCriteria($course, $student);
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRange(DateTime $startDate, DateTime $endDate, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeInTimeRangeWithCriteria($startDate, $endDate, $student);
    }
}
