<?php

namespace App\Controller\Web\Task\UpdateTask\v1;

use App\Controller\Web\Task\UpdateTask\v1\Input\UpdatetaskDTO;
use App\Controller\Web\Task\UpdateTask\v1\Output\UpdatedTaskDTO;
use App\Domain\Entity\Task;
use App\Domain\Model\UpdateTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateTaskModel> */
        private readonly ModelFactory $modelFactory,
        private readonly TaskService $taskService
    ) {
    }

    public function updateTask(Task $task, UpdateTaskDTO $updateTaskDTO): UpdatedTaskDTO
    {
        $updateTaskModel = $this->modelFactory->makeModel(
            UpdateTaskModel::class,
            $updateTaskDTO->name,
            $updateTaskDTO->description
        );

        $task = $this->taskService->update($task, $updateTaskModel);

        return new UpdatedTaskDTO(
            $task->getId(),
            $task->getName(),
            $task->getDescription(),
            $task->getCreatedAt()->format('Y-m-d H:i:s'),
            $task->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
