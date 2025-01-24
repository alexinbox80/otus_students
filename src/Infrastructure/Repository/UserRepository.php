<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;

/**
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{
    /**
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function find(int $userId): ?User
    {
        $repository = $this->entityManager->getRepository(User::class);
        /** @var User|null $user */
        return $repository->find($userId);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    /**
     * @param string $login
     * @return User[]
     */
    public function findUsersByLogin(string $login): array
    {
        return $this->entityManager->getRepository(User::class)->findBy(['login' => $login]);
    }

    /**
     * @param string $refreshToken
     * @return User|null
     */
    public function findUserByRefreshToken(string $refreshToken): ?User
    {
        /** @var User|null $user */
        return $this->entityManager->getRepository(User::class)->findOneBy(['refreshToken' => $refreshToken]);
    }

    /**
     * @param User $user
     * @param string $login
     * @return void
     */
    public function updateLogin(User $user, string $login): void
    {
        $user->setLogin($login);
        $this->flush();
    }

    /**
     * @param User $user
     * @param string $avatarLink
     * @return void
     */
    public function updateAvatarLink(User $user, string $avatarLink): void
    {
        $user->setAvatarLink($avatarLink);
        $this->flush();
    }

    /**
     * @param User $user
     * @return string
     * @throws \Random\RandomException
     */
    public function updateUserRefreshToken(User $user): string
    {
        $refreshToken = base64_encode(random_bytes(20));
        $user->setRefreshToken($refreshToken);
        $this->flush();

        return $refreshToken;
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
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
    public function clearUserRefreshToken(User $user): void
    {
        $user->setRefreshToken(null);
        $this->flush();
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
