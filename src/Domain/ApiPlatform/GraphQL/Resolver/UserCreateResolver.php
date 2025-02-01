<?php

namespace App\Domain\ApiPlatform\GraphQL\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class UserCreateResolver implements QueryItemResolverInterface
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
        $createUserModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $context['args']['input']['login'],
            $context['args']['input']['password'],
            true,
            $context['args']['input']['roles']
        );

        return $this->userService->create($createUserModel);
    }
}