<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Infrastructure\Repository\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param int $userId
     * @return ?User
     */
    public function find(int $userId): ?User
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
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        return $this->userRepository->getUsers($page, $perPage);
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
     * @param User $user
     * @param string $avatarLink
     * @return void
     */
    public function updateAvatarLink(User $user, string $avatarLink): void
    {
        $this->userRepository->updateAvatarLink($user, $avatarLink);
    }

    /**
     * @param CreateUserModel $createUserModel
     * @return User
     */
    public function create(CreateUserModel $createUserModel): User
    {
        $user = new User(
            $createUserModel->login,
            $createUserModel->password,
            $createUserModel->isActive
        );

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

    /**
     * @param User $user
     * @return void
     */
    public function removeUser(User $user): void
    {
        $this->userRepository->remove($user);
    }
}
