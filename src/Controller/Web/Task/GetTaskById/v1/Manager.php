<?php

namespace App\Controller\Web\Task\GetTaskById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Task\GetTaskById\v1\Output\GotTaskByIdDTO;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * @param int $taskId
     * @return GotTaskByIdDTO|EmptyDTO
     */
    public function find(int $taskId): GotTaskByIdDTO|EmptyDTO
    {
        $task = $this->taskService->find($taskId);

        if (!is_null($task)) {
            return new GotTaskByIdDTO(
                $task->getId(),
                $task->getName(),
                $task->getDescription(),
                $task->getCreatedAt()->format('Y-m-d H:i:s'),
                $task->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
