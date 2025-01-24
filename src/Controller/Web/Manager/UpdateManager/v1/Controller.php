<?php

namespace App\Controller\Web\Manager\UpdateManager\v1;

use App\Controller\Web\Manager\UpdateManager\v1\Input\UpdateManagerDTO;
use App\Controller\Web\Manager\UpdateManager\v1\Output\UpdatedManagerDTO;
use App\Domain\Entity\Manager as EntityManager;
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
        path: 'api/v1/manager/{id}',
        name: 'web_update_manager_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] EntityManager $entityManager,
        #[MapRequestPayload] UpdateManagerDTO $updateManagerDTO
    ): UpdatedManagerDTO
    {
        return $this->manager->updateManager($entityManager, $updateManagerDTO);
    }
}
