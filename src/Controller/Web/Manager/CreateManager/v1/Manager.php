<?php

namespace App\Controller\Web\Manager\CreateManager\v1;

use App\Controller\Web\Manager\CreateManager\v1\Input\CreateManagerDTO;
use App\Controller\Web\Manager\CreateManager\v1\Output\CreatedManagerDTO;
use App\Domain\Model\CreateManagerModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\ManagerService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateManagerModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly ManagerService $managerService
    ) {
    }

    public function create(CreateManagerDTO $createManagerDTO): CreatedManagerDTO
    {
        $createManagerModel = $this->modelFactory->makeModel(
            CreateManagerModel::class,
            $createManagerDTO->firstName,
            $createManagerDTO->lastName,
            $createManagerDTO->middleName,
            $createManagerDTO->email,
            $createManagerDTO->phone
        );

        $manager = $this->managerService->create($createManagerModel);

        return new CreatedManagerDTO(
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
