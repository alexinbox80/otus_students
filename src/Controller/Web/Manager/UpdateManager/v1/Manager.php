<?php

namespace App\Controller\Web\Manager\UpdateManager\v1;

use App\Controller\Web\Manager\UpdateManager\v1\Input\UpdateManagerDTO;
use App\Controller\Web\Manager\UpdateManager\v1\Output\UpdatedManagerDTO;
use App\Domain\Entity\Manager as EntityManager;
use App\Domain\Model\UpdateManagerModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\ManagerService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateManageerModel> */
        private readonly ModelFactory $modelFactory,
        private readonly ManagerService $managerService
    ) {
    }

    public function updateManager(EntityManager $entityManager, UpdateManagerDTO $updateManagerDTO): UpdatedManagerDTO
    {
        $updateManagerModel = $this->modelFactory->makeModel(
            UpdateManagerModel::class,
            $updateManagerDTO->firstName,
            $updateManagerDTO->lastName,
            $updateManagerDTO->middleName,
            $updateManagerDTO->email,
            $updateManagerDTO->phone
        );

        $manager = $this->managerService->update($entityManager, $updateManagerModel);

        return new UpdatedManagerDTO(
            $manager->getId(),
            $manager->getFirstName(),
            $manager->getLastName(),
            $manager->getMiddleName(),
            $manager->getEmail(),
            $manager->getPhone(),
            $manager->getCreatedAt()->format('Y-m-d H:i:s'),
            $manager->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
