<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
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
     * @param Student $student
     * @return CompletedTask[]|null
     */
    public function findByStudent(Student $student): array|null
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('student', $student));
        $repository = $this->entityManager->getRepository(CompletedTask::class);

        return $repository->matching($criteria)->toArray();
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

        return $queryBuilder->getQuery()->getResult();
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
}
