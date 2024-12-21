<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use DateInterval;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{
    /**
     * @param int $userId
     * @return User|null
     */
    public function find(int $userId): ?User
    {
        $repository = $this->entityManager->getRepository(User::class);
        /** @var User|null $user */
        $user = $repository->find($userId);

        return $user;
    }

    /**
     * @param string $name
     * @return User[]
     */
    public function findUsersByLogin(string $name): array
    {
        return $this->entityManager->getRepository(User::class)->findBy(['login' => $name]);
    }

    /**
     * @param User $user
     * @return int
     */
    public function create(User $user): int
    {
        return $this->store($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function remove(User $user): void
    {
        $user->setDeletedAt();
        $this->flush();
    }
}
