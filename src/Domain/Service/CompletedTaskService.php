<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use DateTime;
use App\Domain\Entity\CompletedTask;
use App\Infrastructure\Repository\CompletedTaskRepository;

class CompletedTaskService
{
    public function __construct(
        private readonly CompletedTaskRepository $completedTaskRepository
    )
    {
    }

    /**
     * @param int $completedTaskId
     * @return CompletedTask
     */
    public function find(int $completedTaskId): CompletedTask
    {
        return $this->completedTaskRepository->find($completedTaskId);
    }

    /**
     * @return CompletedTask[]
     */
    public function findAll(): array
    {
        return $this->completedTaskRepository->findAll();
    }

    /**
     * @param int $grade
     * @return CompletedTask[]
     */
    public function findCompletedTasksByGrade(int $grade): array
    {
        return $this->completedTaskRepository->findCompletedTasksByGrade($grade);
    }

    /**
     * @param string $description
     * @return CompletedTask[]
     */
    public function findCompletedTasksByDescription(string $description): array
    {
        return $this->completedTaskRepository->findCompletedTasksByDescriptionWithCriteria($description);
    }

    /**
     * @param DateTime $finishedAt
     * @return CompletedTask[]
     */
    public function findCompletedTasksByFinishedAt(DateTime $finishedAt): array
    {
        return $this->completedTaskRepository->findCompletedTasksByFinishedAt($finishedAt);
    }

    /**
     * @param int $completedTaskId
     * @param int $grade
     * @return CompletedTask|null
     */
    public function updateGrade(int $completedTaskId, int $grade): ?CompletedTask
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if (!($completedTask instanceof CompletedTask)) {
            return null;
        }
        $this->completedTaskRepository->updateGrade($completedTask, $grade);

        return $completedTask;
    }

    /**
     * @param int $completedTaskId
     * @param string $description
     * @return CompletedTask|null
     */
    public function updateDescription(int $completedTaskId, string $description): ?CompletedTask
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if (!($completedTask instanceof CompletedTask)) {
            return null;
        }
        $this->completedTaskRepository->updateDescription($completedTask, $description);

        return $completedTask;
    }

    /**
     * @param int $completedTaskId
     * @param DateTime $finishedAt
     * @return CompletedTask|null
     */
    public function updateFinishedAt(int $completedTaskId, DateTime $finishedAt): ?CompletedTask
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if (!($completedTask instanceof CompletedTask)) {
            return null;
        }
        $this->completedTaskRepository->updateFinishedAt($completedTask, $finishedAt);

        return $completedTask;
    }

    /**
     * @param Student $student
     * @param int $grade
     * @param string $description
     * @return CompletedTask
     */
    public function create(Student $student, int $grade, string $description): CompletedTask
    {
        $completedTask = new CompletedTask();
        $completedTask->setGrade($grade);
        $completedTask->setDescription($description);

        $student->addCompletedTask($completedTask);

        $this->completedTaskRepository->create($completedTask);

        return $completedTask;
    }

    /**
     * @param int $completedTaskId
     * @return void
     */
    public function removeById(int $completedTaskId): void
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if ($completedTask instanceof CompletedTask) {
            $this->completedTaskRepository->remove($completedTask);
        }
    }
}
