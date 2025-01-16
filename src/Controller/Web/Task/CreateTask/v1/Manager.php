<?php

namespace App\Controller\Web\Task\CreateTask\v1;

use App\Controller\Web\Task\CreateTask\v1\Input\CreateTaskDTO;
use App\Controller\Web\Task\CreateTask\v1\Output\CreatedTaskDTO;
use App\Domain\Model\CreateTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateTaskModel> */
        private readonly ModelFactory $modelFactory,
        private readonly TaskService $taskService
    ) {
    }

    public function create(CreateTaskDTO $createTaskDTO): CreatedTaskDTO
    {
        $createTaskModel = $this->modelFactory->makeModel(
            CreateTaskModel::class,
            $createTaskDTO->name,
            $createTaskDTO->description
        );

        $task = $this->taskService->create($createTaskModel);

        return new CreatedTaskDTO(
            $task->getId(),
            $task->getName(),
            $task->getDescription(),
            $task->getCreatedAt()->format('Y-m-d H:i:s'),
            $task->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
