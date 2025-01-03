<?php

namespace App\Controller\Web\User\UpdateUser\v1;

use App\Controller\Web\User\UpdateUser\v1\Input\UpdateUserDTO;
use App\Controller\Web\User\UpdateUser\v1\Output\UpdatedUserDTO;
use App\Domain\Entity\User;
use App\Domain\Model\UpdateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService
    ) {
    }

    public function updateUser(User $user, UpdateUserDTO $updateUserDTO): UpdatedUserDTO
    {
        $updateUserModel = $this->modelFactory->makeModel(
            UpdateUserModel::class,
            $updateUserDTO->login,
            $updateUserDTO->password,
            $updateUserDTO->isActive
        );

        $user = $this->userService->update($user, $updateUserModel);

        return new UpdatedUserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getRoles(),
            $user->isActive(),
            $user->getAvatarLink(),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $user->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
