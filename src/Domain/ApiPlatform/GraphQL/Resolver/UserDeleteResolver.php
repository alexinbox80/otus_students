<?php

namespace App\Domain\ApiPlatform\GraphQL\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Domain\Entity\User;
use App\Domain\Service\UserService;

class UserDeleteResolver implements QueryItemResolverInterface
{
    public function __construct(
        private readonly UserService  $userService
    )
    {
    }

    /**
     * @param User|null $item
     */
    public function __invoke($item, array $context): User
    {
        $ids = explode('/', $context['args']['input']['id']);
        $user = $this->userService->find(end($ids));
        $this->userService->removeUser($user);
        return $item;
    }
}
