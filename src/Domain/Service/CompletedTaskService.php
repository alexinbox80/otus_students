<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Domain\Model\CompletedTaskModel;
use App\Domain\Model\CreateCompletedTaskModel;
use App\Domain\Model\UpdateCompletedTaskModel;
use App\Domain\Repository\CompletedTaskRepositoryInterface;
use DateTime;
use App\Domain\Entity\CompletedTask;
use Psr\Cache\InvalidArgumentException;

class CompletedTaskService
{
    public function __construct(
        private readonly CompletedTaskRepositoryInterface $completedTaskRepository
    )
    {
    }

    /**
     * @param int $completedTaskId
     * @return ?CompletedTaskModel
     */
    public function find(int $completedTaskId): ?CompletedTaskModel
    {
        return $this->completedTaskRepository->find($completedTaskId);
    }

    /**
     * @return CompletedTaskModel[]
     */
    public function findAll(): array
    {
        return $this->completedTaskRepository->findAll();
    }

    /**
     * @param int $grade
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByGrade(int $grade): array
    {
        return $this->completedTaskRepository->findCompletedTasksByGrade($grade);
    }

    /**
     * @param string $description
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByDescription(string $description): array
    {
        return $this->completedTaskRepository->findCompletedTasksByDescriptionWithCriteria($description);
    }

    /**
     * @param DateTime $finishedAt
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByFinishedAt(DateTime $finishedAt): array
    {
        return $this->completedTaskRepository->findCompletedTasksByFinishedAt($finishedAt);
    }

    /**
     * @return CompletedTaskModel[]
     * @throws InvalidArgumentException
     */
    public function getCompletedTasksPaginated(int $page, int $perPage): array
    {
        return $this->completedTaskRepository->getCompletedTasksPaginated($page, $perPage);
    }

    /**
     * @param int $completedTaskId
     * @param int $grade
     * @return CompletedTaskModel|null
     * @throws InvalidArgumentException
     */
    public function updateGrade(int $completedTaskId, int $grade): ?CompletedTaskModel
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
     * @return CompletedTaskModel|null
     * @throws InvalidArgumentException
     */
    public function updateDescription(int $completedTaskId, string $description): ?CompletedTaskModel
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
     * @return CompletedTaskModel|null
     * @throws InvalidArgumentException
     */
    public function updateFinishedAt(int $completedTaskId, DateTime $finishedAt): ?CompletedTaskModel
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if (!($completedTask instanceof CompletedTask)) {
            return null;
        }
        $this->completedTaskRepository->updateFinishedAt($completedTask, $finishedAt);

        return $completedTask;
    }

    /**
     * @param CompletedTask $completedTask
     * @param UpdateCompletedTaskModel $updateCompletedTaskModel
     * @return CompletedTaskModel
     * @throws InvalidArgumentException
     */
    public function update(CompletedTask $completedTask, UpdateCompletedTaskModel $updateCompletedTaskModel): CompletedTaskModel
    {
        $completedTask->changeFields(
            $updateCompletedTaskModel->finishedAt,
            $updateCompletedTaskModel->description,
            $updateCompletedTaskModel->grade
        );

        $this->completedTaskRepository->update();

        return new CompletedTaskModel(
            $completedTask->getId(),
            $completedTask->getFinishedAt(),
            $completedTask->getDescription(),
            $completedTask->getGrade(),
            $completedTask->getCreatedAt(),
            $completedTask->getUpdatedAt()
        );
    }

    /**
     * //* @param Student $student
     * @param CreateCompletedTaskModel $createCompletedTaskModel
     * @return CompletedTaskModel
     * @throws InvalidArgumentException
     */

    public function create(
        //Student $student,
        CreateCompletedTaskModel $createCompletedTaskModel): CompletedTaskModel
    {
        $completedTask = new CompletedTask(
            $createCompletedTaskModel->grade,
            $createCompletedTaskModel->description,
            $createCompletedTaskModel->finishedAt
        );

        //$student->addCompletedTask($completedTask);

        $this->completedTaskRepository->create($completedTask);

        return new CompletedTaskModel(
            $completedTask->getId(),
            $completedTask->getFinishedAt(),
            $completedTask->getDescription(),
            $completedTask->getGrade(),
            $completedTask->getCreatedAt(),
            $completedTask->getUpdatedAt()
        );
    }

    /**
     * @param int $completedTaskId
     * @return void
     */
    public function removeById(int $completedTaskId): void
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        if ($completedTask !== null) {
            $this->completedTaskRepository->remove($completedTask);
        }
    }

    /**
     * @param CompletedTask $completedTask
     * @return void
     */
    public function removeCompletedTask(CompletedTask $completedTask): void
    {
        $this->completedTaskRepository->remove($completedTask);
    }
}
