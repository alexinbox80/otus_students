<?php

namespace App\Controller\Web\CompletedTask\CreateCompletedTask\v1;

use App\Controller\Web\CompletedTask\CreateCompletedTask\v1\Input\CreateCompletedTaskDTO;
use App\Controller\Web\CompletedTask\CreateCompletedTask\v1\Output\CreatedCompletedTaskDTO;
use App\Domain\Model\CreateCompletedTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\CompletedTaskService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateCompletedTaskModel> */
        private readonly ModelFactory $modelFactory,
        private readonly CompletedTaskService $completedTaskService,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(CreateCompletedTaskDTO $createCompletedTaskDTO): CreatedCompletedTaskDTO
    {
        $createCompletedTaskModel = $this->modelFactory->makeModel(
            CreateCompletedTaskModel::class,
            $createCompletedTaskDTO->studentId,
            $createCompletedTaskDTO->taskId,
            $createCompletedTaskDTO->finishedAt,
            $createCompletedTaskDTO->description,
            $createCompletedTaskDTO->grade
        );

        $completedTask = $this->completedTaskService->create($createCompletedTaskModel);

        return new CreatedCompletedTaskDTO(
            $completedTask->getId(),
            $completedTask->getStudentId(),
            $completedTask->getTaskId(),
            $completedTask->getFinishedAt(),
            $completedTask->getDescription(),
            $completedTask->getGrade(),
            $completedTask->getCreatedAt()->format('Y-m-d H:i:s'),
            $completedTask->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
