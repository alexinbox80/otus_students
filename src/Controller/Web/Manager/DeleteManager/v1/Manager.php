<?php

namespace App\Controller\Web\Manager\DeleteManager\v1;

use App\Controller\Web\Manager\DeleteManager\v1\Output\DeletedManagerDTO;
use App\Domain\Entity\Manager as EntityManager;
use App\Domain\Service\ManagerService;

class Manager
{
    public function __construct(
        private readonly ManagerService $managerService
    ) {
    }

    public function deleteManager(EntityManager $entityManager): DeletedManagerDTO
    {
        $this->managerService->removeManager($entityManager);
        return new DeletedManagerDTO();
    }
}
