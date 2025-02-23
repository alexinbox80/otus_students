<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Percentage;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\ValueObject\RedisCacheTagEnum;
use DateTime;
use App\Domain\Entity\CompletedTask;
use Doctrine\Common\Collections\Criteria;

class CompletedTaskRepository extends AbstractRepository
{
    /**
     * @param int $completedTaskId
     * @return CompletedTask|null
     */
    public function find(int $completedTaskId): ?CompletedTask
    {
        $repository = $this->entityManager->getRepository(CompletedTask::class);
        /** @var CompletedTask|null $completedTask */
        $completedTask = $repository->find($completedTaskId);

        return $completedTask;
    }

    /**
     * @return CompletedTask[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(CompletedTask::class)->findAll();
    }

    /**
     * @param int $grade
     * @return CompletedTask[]
     */
    public function findCompletedTasksByGrade(int $grade): array
    {
        return $this->entityManager->getRepository(CompletedTask::class)->findBy(['grade' => $grade]);
    }

    /**
     * @param DateTime $finishedAt
     * @return CompletedTask[]
     */
    public function findCompletedTasksByFinishedAt(DateTime $finishedAt): array
    {
        return $this->entityManager->getRepository(CompletedTask::class)->findBy(['finished_at' => $finishedAt]);
    }

    /**
     * @param string $description
     * @return CompletedTask[]
     */
    public function findCompletedTasksByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(CompletedTask::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @return CompletedTask[]
     */
    public function getCompletedTasksPaginated(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c')
            ->from(CompletedTask::class, 'c')
            ->orderBy('c.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder
        ->getQuery()
        ->enableResultCache(null, RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value . "_{$page}_$perPage")
        ->getResult();
    }

    /**
     * @param CompletedTask $completedTask
     * @param int $grade
     * @return void
     */
    public function updateGrade(CompletedTask $completedTask, int $grade): void
    {
        $completedTask->setGrade($grade);
        $this->flush();
    }

    /**
     * @param CompletedTask $completedTask
     * @param string $description
     * @return void
     */
    public function updateDescription(CompletedTask $completedTask, string $description): void
    {
        $completedTask->setDescription($description);
        $this->flush();
    }

    /**
     * @param CompletedTask $completedTask
     * @param DateTime $finishedAt
     * @return void
     */
    public function updateFinishedAt(CompletedTask $completedTask, DateTime $finishedAt): void
    {
        $completedTask->updateFinishedAt($finishedAt);
        $this->flush();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param CompletedTask $completedTask
     * @return int
     */
    public function create(CompletedTask $completedTask): int
    {
        return $this->store($completedTask);
    }

    /**
     * @param CompletedTask $completedTask
     * @return void
     */
    public function remove(CompletedTask $completedTask): void
    {
        $completedTask->setDeletedAt();
        $this->flush();
    }

    /**
     * Получаем суммарный бал за все задания урока для конкретного студента
     *
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLessonWithCriteria(Lesson $lesson, Student $student): float
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('student', $student));
        $criteria->andWhere(Criteria::expr()?->contains('task', $lesson->getTasks()));

        $repository = $this->entityManager->getRepository(CompletedTask::class);
        $completedTasks = $repository->matching($criteria)->toArray();

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            $totalGrade += $completedTask->getGrade();
        }

        return $totalGrade;
    }

    /**
     * Получаем суммарный бал по всем выполненным заданиям студента, для указанного навыка
     *
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkillWithCriteria(Skill $skill, Student $student): float
    {
        $completedTasks = $this->entityManager->getRepository(CompletedTask::class)->findBy(['student' => $student]);

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            /** @var Percentage $percentage */
            foreach ($completedTask->getTask()->getPercentages() as $percentage) {
                if ($percentage->getSkill() === $skill) {
                    $totalGrade += 0.01 * $percentage->getPercent() * $completedTask->getGrade();
                }
            }
        }

        return $totalGrade;
    }

    /**
     * Получаем суммарный бал студента по всем выполненным заданиям указанного курса
     *
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourseWithCriteria(Course $course, Student $student): float
    {
        $completedTasks = $this->entityManager->getRepository(CompletedTask::class)->findBy(['student' => $student]);

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            if ($completedTask->getTask()->getLesson()->getCourse() === $course) {
                $totalGrade += $completedTask->getGrade();
            }
        }

        return $totalGrade;
    }

    /**
     * Получаем суммарный бал студента по всем выполненным заданиям за указанный интервал времени
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRangeWithCriteria(DateTime $startDate, DateTime $endDate, Student $student): float
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('student', $student));
        $criteria->andWhere(Criteria::expr()?->gte('finishedAt', $startDate));
        $criteria->andWhere(Criteria::expr()?->lte('finishedAt', $endDate));

        $repository = $this->entityManager->getRepository(CompletedTask::class);
        $completedTasks = $repository->matching($criteria)->toArray();

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            $totalGrade += $completedTask->getGrade();
        }

        return $totalGrade;
    }
}
