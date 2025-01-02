<?php

namespace App\Controller\Web\User\GetUser\v1;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @return User[]
     */
    public function getUsers(?int $page, ?int $perPage): array
    {
        return $this->userService->getUsers($page, $perPage);
    }
}
