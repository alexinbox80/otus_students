<?php

namespace App\Controller\Web\Task\CreateTask\v1;

use App\Controller\Web\Task\CreateTask\v1\Input\CreateTaskDTO;
use App\Controller\Web\Task\CreateTask\v1\Output\CreatedTaskDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/task',
        name: 'web_create_task_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateTaskDTO $createTaskDTO): CreatedTaskDTO
    {
        return $this->manager->create($createTaskDTO);
    }
}
