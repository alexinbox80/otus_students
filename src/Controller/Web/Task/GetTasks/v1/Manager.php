<?php

namespace App\Controller\Web\Task\GetTasks\v1;

use App\Domain\Entity\Task;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * @return Task[]
     */
    public function getTasks(?int $page, ?int $perPage): array
    {
        return $this->taskService->getTasks($page, $perPage);
    }
}
