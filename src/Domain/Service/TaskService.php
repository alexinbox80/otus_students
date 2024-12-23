<?php

namespace App\Domain\Service;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\Task;
use App\Infrastructure\Repository\TaskRepository;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    )
    {
    }

    /**
     * @param int $taskId
     * @return Task
     */
    public function find(int $taskId): Task
    {
        return $this->taskRepository->find($taskId);
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @param string $name
     * @return Task[]
     */
    public function findTasksByName(string $name): array
    {
        return $this->taskRepository->findTasksByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return Task[]
     */
    public function findTasksByDescription(string $description): array
    {
        return $this->taskRepository->findTasksByDescriptionWithCriteria($description);
    }

    /**
     * @param int $taskId
     * @param string $name
     * @return Task|null
     */
    public function updateName(int $taskId, string $name): ?Task
    {
        $task = $this->taskRepository->find($taskId);
        if (!($task instanceof Task)) {
            return null;
        }
        $this->taskRepository->updateName($task, $name);

        return $task;
    }

    /**
     * @param int $taskId
     * @param string $description
     * @return Task|null
     */
    public function updateDescription(int $taskId, string $description): ?Task
    {
        $task = $this->taskRepository->find($taskId);
        if (!($task instanceof Task)) {
            return null;
        }
        $this->taskRepository->updateDescription($task, $description);

        return $task;
    }

    /**
     * @param Lesson $lesson
     * @param string $name
     * @param string $description
     * @return Task
     */
    public function create(Lesson $lesson, string $name, string $description): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $lesson->addTask($task);
        $this->taskRepository->create($task);

        return $task;
    }

    /**
     * @param Task $task
     * @param Lesson $lesson
     * @return Task
     */
    public function changeLesson(Task $task, Lesson $lesson): Task
    {
        $task->getLesson()->removeTask($task);
        $task->removeLesson()->setLesson($lesson);
        $this->taskRepository->flush();

        return $task;
    }

    /**
     * @param int $taskId
     * @return void
     */
    public function removeById(int $taskId): void
    {
        $task = $this->taskRepository->find($taskId);
        if ($task instanceof Task) {
            $this->taskRepository->remove($task);
        }
    }
}
