<?php

namespace App\Controller\Web\Manager\GetManagers\v1;

use App\Domain\Entity\Manager as EntityManager;
use App\Domain\Service\ManagerService;

class Manager
{
    public function __construct(private readonly ManagerService $managerService)
    {
    }

    /**
     * @return EntityManager[]
     */
    public function getManagers(?int $page, ?int $perPage): array
    {
        return $this->managerService->getManagers($page, $perPage);
    }
}
