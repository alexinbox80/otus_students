<?php

namespace App\Controller\Web\User\GetUserById\v1;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param int $userId
     * @return ?User
     */
    public function find(int $userId): ?User
    {
        return $this->userService->find($userId);
    }
}
