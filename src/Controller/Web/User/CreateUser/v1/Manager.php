<?php

namespace App\Controller\Web\User\CreateUser\v1;

use App\Controller\Web\User\CreateUser\v1\Input\CreateUserDTO;
use App\Controller\Web\User\CreateUser\v1\Output\CreatedUserDTO;
use App\Domain\Event\CreateUserEvent;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use App\Domain\ValueObject\RoleEnum;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function create(CreateUserDTO $createUserDTO, UserInterface $user): CreatedUserDTO
    {
        $roles = $user->getRoles();
        if (count($roles) > 0) {
            $role = [$roles[0]];
        } else {
            $role = [RoleEnum::ROLE_STUDENT->value];
        }

        $createUserModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->isActive,
            $role
        );

        $user = $this->userService->create($createUserModel);

        $activationCode = rand(100000, 999999);
        $event = new CreateUserEvent($user->getId(), $user->getLogin(), $activationCode);
        $event = $this->eventDispatcher->dispatch($event);

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
