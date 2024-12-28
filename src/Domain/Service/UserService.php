<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param int $userId
     * @return User
     */
    public function find(int $userId): User
    {
        return $this->userRepository->find($userId);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param string $login
     * @return User[]
     */
    public function findUsersByLogin(string $login): array
    {
        return $this->userRepository->findUsersByLogin($login);
    }

    /**
     * @param int $userId
     * @param string $login
     * @return User|null
     */
    public function updateUserLogin(int $userId, string $login): ?User
    {
        $user = $this->userRepository->find($userId);
        if (!($user instanceof User)) {
            return null;
        }
        $this->userRepository->updateLogin($user, $login);

        return $user;
    }

    /**
     * @param string $login
     * @param string $password
     * @return User
     */
    public function create(string $login, string $password): User
    {
        $user = new User($login, $password);

        $user->setIsActive(true);
        $this->userRepository->create($user);

        return $user;
    }

    /**
     * @param int $userId
     * @return void
     */
    public function removeById(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if ($user instanceof User) {
            $this->userRepository->remove($user);
        }
    }
}
