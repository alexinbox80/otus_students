<?php

namespace App\Controller\Web\User\CreateUser\v1;

use App\Controller\Web\User\CreateUser\v1\Input\CreateUserDTO;
use App\Controller\Web\User\CreateUser\v1\Output\CreatedUserDTO;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService,
    ) {
    }

    public function create(CreateUserDTO $createUserDTO): CreatedUserDTO
    {
        $createUserModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->isActive
        );

        $user = $this->userService->create($createUserModel);

        return new CreatedUserDTO(
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
