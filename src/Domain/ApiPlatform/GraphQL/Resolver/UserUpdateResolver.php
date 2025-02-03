<?php

namespace App\Domain\ApiPlatform\GraphQL\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Domain\Entity\User;
use App\Domain\Model\UpdateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class UserUpdateResolver implements QueryItemResolverInterface
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly UserService  $userService
    )
    {
    }

    /**
     * @param User|null $item
     */
    public function __invoke($item, array $context): User
    {
        $updateUserModel = $this->modelFactory->makeModel(
            UpdateUserModel::class,
            $context['args']['input']['login'],
            $context['args']['input']['password'],
            true,
            $context['args']['input']['roles']
        );

        $ids = explode('/', $context['args']['input']['id']);
        $user = $this->userService->find(end($ids));
        return $this->userService->update($user, $updateUserModel);
    }
}
