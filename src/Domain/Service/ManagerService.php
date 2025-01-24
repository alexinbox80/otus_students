<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Manager;
use App\Domain\Model\CreateManagerModel;
use App\Domain\Model\UpdateManagerModel;
use App\Infrastructure\Repository\ManagerRepository;

class ManagerService
{
    public function __construct(private readonly ManagerRepository $managerRepository)
    {
    }

    /**
     * @param int $managerId
     * @return ?Manager
     */
    public function find(int $managerId): ?Manager
    {
        return $this->managerRepository->find($managerId);
    }

    /**
     * @return Manager[]
     */
    public function findAll(): array
    {
        return $this->managerRepository->findAll();
    }

    /**
     * @param string $lastName
     * @return Manager[]
     */
    public function findManagersByLastName(string $lastName): array
    {
        return $this->managerRepository->findManagersByLastName($lastName);
    }

    /**
     * @param string $firstName
     * @return Manager[]
     */
    public function findManagersByFirstName(string $firstName): array
    {
        return $this->managerRepository->findManagersByFirstName($firstName);
    }

    /**
     * @param string $middleName
     * @return Manager[]
     */
    public function findManagersByMiddleName(string $middleName): array
    {
        return $this->managerRepository->findManagersByMiddleName($middleName);
    }

    /**
     * @return Manager[]
     */
    public function getManagers(int $page, int $perPage): array
    {
        return $this->managerRepository->getManagers($page, $perPage);
    }

    /**
     * @param int $managerId
     * @param Person $person
     * @return Manager|null
     */
    public function updateName(int $managerId, Person $person): ?Manager
    {
        $manager = $this->managerRepository->find($managerId);
        if (!($manager instanceof Manager)) {
            return null;
        }
        $this->managerRepository->updateName($manager, $person);

        return $manager;
    }

    /**
     * @param int $managerId
     * @param Person $person
     * @return Manager|null
     */
    public function updateContact(int $managerId, Person $person): ?Manager
    {
        $manager = $this->managerRepository->find($managerId);
        if (!($manager instanceof Manager)) {
            return null;
        }
        $this->managerRepository->updateContact($manager, $person);

        return $manager;
    }

    /**
     * @param CreateManagerModel $createManagerModel
     * @return Manager
     */
    public function create(CreateManagerModel $createManagerModel): Manager
    {
        $manager = new Manager(
            $createManagerModel->firstName,
            $createManagerModel->lastName,
            $createManagerModel->middleName,
            $createManagerModel->email,
            $createManagerModel->phone
        );

        $this->managerRepository->create($manager);

        return $manager;
    }

    /**
     * @param Manager $manager
     * @param UpdateManagerModel $updateManagerModel
     * @return Manager
     */
    public function update(Manager $manager, UpdateManagerModel $updateManagerModel): Manager
    {
        $manager->changeFields(
            $updateManagerModel->firstName,
            $updateManagerModel->lastName,
            $updateManagerModel->middleName,
            $updateManagerModel->email,
            $updateManagerModel->phone
        );

        $this->managerRepository->update();

        return $manager;
    }

    /**
     * @param int $managerId
     * @return void
     */
    public function removeById(int $managerId): void
    {
        $manager = $this->managerRepository->find($managerId);
        if ($manager instanceof Manager) {
            $this->managerRepository->remove($manager);
        }
    }

    /**
     * @param Manager $manager
     * @return void
     */
    public function removeManager(Manager $manager): void
    {
        $this->managerRepository->remove($manager);
    }
}
