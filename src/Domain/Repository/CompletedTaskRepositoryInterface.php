<?php

namespace App\Domain\Repository;

use App\Domain\Entity\CompletedTask;
use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Model\CompletedTaskModel;
use Psr\Cache\InvalidArgumentException;
use DateTime;

interface CompletedTaskRepositoryInterface
{
    /**
     * @param int $completedTaskId
     * @return CompletedTaskModel|null
     */
    public function find(int $completedTaskId): ?CompletedTaskModel;

    /**
     * @return CompletedTaskModel[]
     */
    public function findAll(): array;

    /**
     * @param int $grade
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByGrade(int $grade): array;

    /**
     * @param DateTime $finishedAt
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByFinishedAt(DateTime $finishedAt): array;

    /**
     * @param string $description
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByDescriptionWithCriteria(string $description): array;

    /**
     * @return CompletedTaskModel[]
     * @throws InvalidArgumentException
     */
    public function getCompletedTasksPaginated(int $page, int $perPage): array;

    /**
     * @param CompletedTask $completedTask
     * @param int $grade
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateGrade(CompletedTask $completedTask, int $grade): void;

    /**
     * @param CompletedTask $completedTask
     * @param string $description
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateDescription(CompletedTask $completedTask, string $description): void;

    /**
     * @param CompletedTask $completedTask
     * @param DateTime $finishedAt
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateFinishedAt(CompletedTask $completedTask, DateTime $finishedAt): void;

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void;

    /**
     * @param CompletedTask $completedTask
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(CompletedTask $completedTask): int;

    /**
     * @param CompletedTask $completedTask
     * @return void
     */
    public function remove(CompletedTask $completedTask): void;

    /**
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLesson(Lesson $lesson, Student $student): float;

    /**
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float;

    /**
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float;

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRange(DateTime $startDate, DateTime $endDate, Student $student): float;
}
