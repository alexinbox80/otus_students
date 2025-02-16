<?php

namespace App\Controller\Web\CompletedTask\GetCompletedTaskById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\CompletedTask\GetCompletedTaskById\v1\Output\GotCompletedTaskByIdDTO;
use App\Domain\Service\CompletedTaskService;

class Manager
{
    public function __construct(private readonly CompletedTaskService $completedTaskService)
    {
    }

    /**
     * @param int $completedTaskId
     * @return GotCompletedTaskByIdDTO|EmptyDTO
     */
    public function find(int $completedTaskId): GotCompletedTaskByIdDTO|EmptyDTO
    {
        $completedTask = $this->completedTaskService->find($completedTaskId);

        if (!is_null($completedTask)) {
            return new GotCompletedTaskByIdDTO(
                $completedTask->id,
                $completedTask->finishedAt,
                $completedTask->description,
                $completedTask->grade,
                $completedTask->createdAt->format('Y-m-d H:i:s'),
                $completedTask->updatedAt->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
