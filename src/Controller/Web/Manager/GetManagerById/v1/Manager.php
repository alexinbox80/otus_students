<?php

namespace App\Controller\Web\Manager\GetManagerById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Manager\GetManagerById\v1\Output\GotManagerByIdDTO;
use App\Domain\Service\ManagerService;

class Manager
{
    public function __construct(private readonly ManagerService $managerService)
    {
    }

    /**
     * @param int $managerId
     * @return GotmanagerByIdDTO|EmptyDTO
     */
    public function find(int $managerId): GotManagerByIdDTO|EmptyDTO
    {
        $manager = $this->managerService->find($managerId);

        if (!is_null($manager)) {
            return new GotManagerByIdDTO(
                $manager->getId(),
                $manager->getLastName(),
                $manager->getFirstName(),
                $manager->getMiddleName(),
                $manager->getPhone(),
                $manager->getEmail(),
                $manager->getCreatedAt()->format('Y-m-d H:i:s'),
                $manager->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
