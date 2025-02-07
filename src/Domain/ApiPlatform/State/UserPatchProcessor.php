<?php

namespace App\Domain\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\ApiPlatform\DTO\Input\CreateUserDTO;
use App\Domain\ApiPlatform\DTO\Output\CreatedUserDTO;
use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Model\UpdateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

/**
 * @implements ProcessorInterface<User, User|void>
 */
class UserPatchProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService
    ) {
    }

    /**
     * @param CreateUserDTO $data
     * @return CreatedUserDTO
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CreatedUserDTO
    {
        if ($operation instanceof Patch) {
            $updateUserModel = $this->modelFactory->makeModel(
                UpdateUserModel::class,
                $data->login,
                $data->password,
                $data->isActive,
                $data->roles
            );

            $userId = $uriVariables['id'];
            $user = $this->userService->update(
                $this->userService->find($userId),
                $updateUserModel
            );
        }

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
