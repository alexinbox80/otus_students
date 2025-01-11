<?php

namespace App\Controller\Web\Task\DeleteTask\v1;

use App\Controller\Web\Task\DeleteTask\v1\Output\DeletedTaskDTO;
use App\Domain\Entity\Task;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly TaskService $taskService
    ) {
    }

    public function deleteTask(Task $task): DeletedTaskDTO
    {
        $this->taskService->removeTask($task);
        return new DeletedTaskDTO();
    }
}
