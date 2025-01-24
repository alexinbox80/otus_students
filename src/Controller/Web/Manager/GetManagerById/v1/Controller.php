<?php

namespace App\Controller\Web\Manager\GetManagerById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Manager\GetManagerById\v1\Output\GotManagerByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-manager-by-id/{id}',
        name: 'web_get_manager_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotManagerByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
