<?php

namespace App\Controller\Web\Task\DeleteTask\v1;

use App\Controller\Web\Task\DeleteTask\v1\Output\DeletedTaskDTO;
use App\Domain\Entity\Task;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
        name: 'web_delete_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Task $task): DeletedTaskDTO
    {
        return $this->manager->deleteTask($task);
    }
}
