<?php

namespace App\Controller\Web\Task\UpdateTask\v1;

use App\Controller\Web\Task\UpdateTask\v1\Input\UpdateTaskDTO;
use App\Controller\Web\Task\UpdateTask\v1\Output\UpdatedTaskDTO;
use App\Domain\Entity\Task;
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
        path: 'api/v1/task/{id}',
        name: 'web_update_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Task $task,
        #[MapRequestPayload] UpdateTaskDTO $updateTaskDTO
    ): UpdatedTaskDTO
    {
        return $this->manager->updateTask($task, $updateTaskDTO);
    }
}
