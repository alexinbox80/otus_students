<?php

namespace App\Controller\Web\CompletedTask\GetCompletedTasks\v1;

use App\Domain\Entity\CompletedTask;
use App\Domain\Service\CompletedTaskService;

class Manager
{
    public function __construct(private readonly CompletedTaskService $completedTaskService)
    {
    }

    /**
     * @return CompletedTask[]
     */
    public function getCompletedTasks(?int $page, ?int $perPage): array
    {
        return $this->completedTaskService->getCompletedTasks($page, $perPage);
    }
}
