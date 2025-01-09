<?php

namespace App\Controller\Web\CompletedTask\UpdateCompletedTask\v1;

use App\Controller\Web\CompletedTask\UpdateCompletedTask\v1\Input\UpdateCompletedTaskDTO;
use App\Controller\Web\CompletedTask\UpdateCompletedTask\v1\Output\UpdatedCompletedTaskDTO;
use App\Domain\Entity\CompletedTask;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/completed-task/{id}',
        name: 'web_update_completed_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] CompletedTask $completedTask,
        #[MapRequestPayload] UpdateCompletedTaskDTO $updateCompletedTaskDTO
    ): UpdatedCompletedTaskDTO
    {
        return $this->manager->updateCompletedTask($completedTask, $updateCompletedTaskDTO);
    }
}
