<?php

namespace App\Controller\Web\CompletedTask\UpdateCompletedTask\v1;

use App\Controller\Web\CompletedTask\UpdateCompletedTask\v1\Input\UpdateCompletedTaskDTO;
use App\Controller\Web\CompletedTask\UpdateCompletedTask\v1\Output\UpdatedCompletedTaskDTO;
use App\Domain\Entity\CompletedTask;
use App\Domain\Model\UpdateCompletedTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\CompletedTaskService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateCompletedTaskModel> */
        private readonly ModelFactory $modelFactory,
        private readonly CompletedTaskService $completedTaskService
    ) {
    }

    public function updateCompletedTask(CompletedTask $completedTask, UpdateCompletedTaskDTO $updateCompletedTaskDTO): UpdatedCompletedTaskDTO
    {
        $updateCompletedTaskModel = $this->modelFactory->makeModel(
            UpdateCompletedTaskModel::class,
            $updateCompletedTaskDTO->finishedAt,
            $updateCompletedTaskDTO->description,
            $updateCompletedTaskDTO->grade
        );

        $completedTask = $this->completedTaskService->update($completedTask, $updateCompletedTaskModel);

        return new UpdatedCompletedTaskDTO(
            $completedTask->getId(),
            $completedTask->getFinishedAt(),
            $completedTask->getDescription(),
            $completedTask->getGrade(),
            $completedTask->getCreatedAt()->format('Y-m-d H:i:s'),
            $completedTask->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
