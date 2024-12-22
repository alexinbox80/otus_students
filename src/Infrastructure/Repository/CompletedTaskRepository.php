<?php

namespace App\Infrastructure\Repository;

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
