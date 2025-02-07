<?php

namespace App\Domain\ApiPlatform\State;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Entity\User;
use App\Domain\Service\UserService;

/**
 * @implements ProcessorInterface<User, User|void>
 */
class UserDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    /**
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if ($operation instanceof Delete) {
            $userId = $uriVariables['id'];
            $this->userService->removeById($userId);
        }
    }
}
