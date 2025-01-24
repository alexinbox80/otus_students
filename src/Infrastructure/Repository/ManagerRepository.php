<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Manager;

/**
 * @extends AbstractRepository<Manager>
 */
class ManagerRepository extends AbstractRepository
{
    /**
     * @return Manager[]
     */
    public function getManagers(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('m')
            ->from(Manager::class, 'm')
            ->orderBy('m.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $managerId
     * @return Manager|null
     */
    public function find(int $managerId): ?Manager
    {
        $repository = $this->entityManager->getRepository(Manager::class);
        /** @var Manager|null $manager */
        $manager = $repository->find($managerId);

        return $manager;
    }

    /**
     * @return Manager[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Manager::class)->findAll();
    }

    /**
     * @param string $firstName
     * @return Manager[]
     */
    public function findManagersByFirstName(string $firstName): array
    {
        return $this->entityManager->getRepository(Manager::class)->findBy(['firstName' => $firstName]);
    }

    /**
     * @param string $lastName
     * @return Manager[]
     */
    public function findManagersByLastName(string $lastName): array
    {
        return $this->entityManager->getRepository(Manager::class)->findBy(['lastName' => $lastName]);
    }

    /**
     * @param string $middleName
     * @return Manager[]
     */
    public function findManagersByMiddleName(string $middleName): array
    {
        return $this->entityManager->getRepository(Manager::class)->findBy(['middleName' => $middleName]);
    }

    /**
     * @param Manager $manager
     * @param Person $person
     * @return void
     */
    public function updateName(Manager $manager, Person $person): void
    {
        $manager->changeName(
            $person->getFirstName(),
            $person->getLastName(),
            $person->getMiddleName()
        );
        $this->flush();
    }

    /**
     * @param Manager $manager
     * @param Person $person
     * @return void
     */
    public function updateContact(Manager $manager, Person $person): void
    {
        $manager->changeContacts(
            $person->getEmail(),
            $person->getPhone()
        );
        $this->flush();
    }

    /**
     * @param Manager $manager
     * @return int
     */
    public function create(Manager $manager): int
    {
        return $this->store($manager);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param Manager $manager
     * @return void
     */
    public function remove(Manager $manager): void
    {
        $manager->setDeletedAt();
        $this->flush();
    }
}
