<?php

namespace App\Controller\Web\CompletedTask\DeleteCompletedTask\v1;

use App\Controller\Web\CompletedTask\DeleteCompletedTask\v1\Output\DeletedCompletedTaskDTO;
use App\Domain\Entity\CompletedTask;
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
        path: 'api/v1/completed-task/{id}',
        name: 'web_delete_completed_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] CompletedTask $completedTask): DeletedCompletedTaskDTO
    {
        return $this->manager->deleteCompletedTask($completedTask);
    }
}
