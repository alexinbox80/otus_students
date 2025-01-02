<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Task;
use Doctrine\Common\Collections\Criteria;

class TaskRepository extends AbstractRepository
{
    /**
     * @param int $taskId
     * @return Task|null
     */
    public function find(int $taskId): ?Task
    {
        $repository = $this->entityManager->getRepository(Task::class);
        /** @var Task|null $task */
        $task = $repository->find($taskId);

        return $task;
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }

    /**
     * @param string $name
     * @return Task[]
     */
    public function findTaskByName(string $name): array
    {
        return $this->entityManager->getRepository(Task::class)->findBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Task[]
     */
    public function findTasksByNameWithCriteria(string $name): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('name', $name));
        $repository = $this->entityManager->getRepository(Task::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param string $description
     * @return Task[]
     */
    public function findTasksByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Task::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Task $task
     * @param string $name
     * @return void
     */
    public function updateName(Task $task, string $name): void
    {
        $task->setName($name);
        $this->flush();
    }

    /**
     * @param Task $task
     * @param string $description
     * @return void
     */
    public function updateDescription(Task $task, string $description): void
    {
        $task->setDescription($description);
        $this->flush();
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->flush();
    }

    /**
     * @param Task $task
     * @return int
     */
    public function create(Task $task): int
    {
        return $this->store($task);
    }

    /**
     * @param Task $task
     * @return void
     */
    public function remove(Task $task): void
    {
        $task->setDeletedAt();
        $this->flush();
    }
}
