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
    public function findUsersByLogin(string $login): array
    {
        return $this->userRepository->findUsersByLogin($login);
    }


    public function create(string $login, string $password): User
    {
        $user = new User();
        $user->setLogin($login);
        $user->setPassword($password);
        $user->setIsActive(true);
        $this->userRepository->create($user);

        return $user;
    }

    public function removeById(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if ($user instanceof User) {
            $this->userRepository->remove($user);
        }
    }
}
