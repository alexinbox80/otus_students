<?php

namespace App\Controller\Web\Manager\CreateManager\v1;

use App\Controller\Web\Manager\CreateManager\v1\Input\CreateManagerDTO;
use App\Controller\Web\Manager\CreateManager\v1\Output\CreatedManagerDTO;
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
        path: 'api/v1/manager',
        name: 'web_create_manager_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateManagerDTO $createManagerDTO): CreatedManagerDTO
    {
        return $this->manager->create($createManagerDTO);
    }
}
