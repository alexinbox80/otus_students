<?php

namespace App\Controller\Web\CompletedTask\GetCompletedTaskById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\CompletedTask\GetCompletedTaskById\v1\Output\GotCompletedTaskByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-completed-task-by-id/{id}',
        name: 'web_get_completed_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotCompletedTaskByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
