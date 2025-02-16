<?php

namespace App\Controller\Web\CompletedTask\GetCompletedTasksPaginated\v1;

use App\Controller\Web\CompletedTask\GetCompletedTasksPaginated\v1\Output\CompletedTaskDTO;
use App\Domain\Model\CompletedTaskModel;
use App\Domain\Service\CompletedTaskService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(private readonly CompletedTaskService $completedTaskService)
    {
    }

    /**
     * @return CompletedTaskModel[]
     * @throws InvalidArgumentException
     */
    public function getCompletedTasks(?int $page, ?int $perPage): array
    {
        return array_map(
            static fn (CompletedTaskModel $completedTask) => new CompletedTaskDTO(
                $completedTask->getId(),
                $completedTask->getStudentId(),
                $completedTask->getTaskId(),
                $completedTask->getFinishedAt(),
                $completedTask->getDescription(),
                $completedTask->getGrade(),
                $completedTask->getCreatedAt()->format('Y-m-d H:i:s'),
                $completedTask->getUpdatedAt()->format('Y-m-d H:i:s')
            ),
            $this->completedTaskService->getCompletedTasksPaginated($page, $perPage)
        );
    }
}
