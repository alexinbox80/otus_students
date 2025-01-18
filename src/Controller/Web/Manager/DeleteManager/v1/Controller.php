<?php

namespace App\Controller\Web\Manager\DeleteManager\v1;

use App\Controller\Web\Manager\DeleteManager\v1\Output\DeletedManagerDTO;
use App\Domain\Entity\Manager as EntityManager;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route(
        path: 'api/v1/manager/{id}',
        name: 'web_delete_manager_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] EntityManager $entityManager): DeletedManagerDTO
    {
        return $this->manager->deleteManager($entityManager);
    }
}
