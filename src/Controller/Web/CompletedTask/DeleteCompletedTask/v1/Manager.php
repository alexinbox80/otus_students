<?php

namespace App\Controller\Web\CompletedTask\DeleteCompletedTask\v1;

use App\Controller\Web\CompletedTask\DeleteCompletedTask\v1\Output\DeletedCompletedTaskDTO;
use App\Domain\Entity\CompletedTask;
use App\Domain\Service\CompletedTaskService;

class Manager
{
    public function __construct(
        private readonly CompletedTaskService $completedTaskService
    ) {
    }

    public function deleteCompletedTask(CompletedTask $completedTask): DeletedCompletedTaskDTO
    {
        $this->completedTaskService->removeCompletedTask($completedTask);
        return new DeletedCompletedTaskDTO();
    }
}
