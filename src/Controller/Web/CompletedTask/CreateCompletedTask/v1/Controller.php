<?php

namespace App\Controller\Web\CompletedTask\CreateCompletedTask\v1;

use App\Controller\Web\CompletedTask\CreateCompletedTask\v1\Input\CreateCompletedTaskDTO;
use App\Controller\Web\CompletedTask\CreateCompletedTask\v1\Output\CreatedCompletedTaskDTO;
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
        path: 'api/v1/completed-task',
        name: 'web_create_completed_task_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateCompletedTaskDTO $createCompletedTaskDTO): CreatedCompletedTaskDTO
    {
        return $this->manager->create($createCompletedTaskDTO);
    }
}
