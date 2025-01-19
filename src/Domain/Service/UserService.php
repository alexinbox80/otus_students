<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Model\UpdateUserModel;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    )
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
     * @param string $login
     * @return User|null
     */
    public function findUserByLogin(string $login): ?User
    {
        $users = $this->userRepository->findUsersByLogin($login);
        return $users[0] ?? null;
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function findUserByRefreshToken(string $token): ?User
    {
        return $this->userRepository->findUserByRefreshToken($token);
    }

    /**
     * @param string $login
     * @return void
     */
    public function clearUserRefreshToken(string $login): void
    {
        $user = $this->findUserByLogin($login);

        if ($user !== null) {
            $this->userRepository->clearUserRefreshToken($user);
        }
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
     * @param string $login
     * @return string|null
     * @throws \Random\RandomException
     */
    public function updateUserRefreshToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user === null) {
            return null;
        }

        return $this->userRepository->updateUserRefreshToken($user);
    }

    /**
     * @param CreateUserModel $createUserModel
     * @return User
     */
    public function create(CreateUserModel $createUserModel): User
    {
        $user = new User();
        $user->changeFields(
            $createUserModel->login,
            $this->userPasswordHasher->hashPassword($user, $createUserModel->password),
            $createUserModel->isActive,
            $createUserModel->avatarLink,
            $createUserModel->roles
        );

        $this->userRepository->create($user);

        return $user;
    }

    /**
     * @param User $user
     * @param UpdateUserModel $updateUserModel
     * @return User
     */
    public function update(User $user, UpdateUserModel $updateUserModel): User
    {
        $user->changeFields(
            $updateUserModel->login,
            $this->userPasswordHasher->hashPassword($user, $updateUserModel->password),
            $updateUserModel->isActive,
            $updateUserModel->avatarLink,
            $updateUserModel->roles
        );

        $this->userRepository->update();

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
