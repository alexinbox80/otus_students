<?php

namespace App\Controller\Web\Task\GetTaskById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Task\GetTaskById\v1\Output\GotTaskByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-task-by-id/{id}',
        name: 'web_get_task_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotTaskByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
