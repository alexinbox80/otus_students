<?php

namespace App\Controller\Web\User\GetUserByLogin\v1;

use App\Domain\Service\UserService;

class Manager
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param string $login
     * @return array
     */
    public function findUsersByLogin(string $login): array
    {
        return $this->userService->findUsersByLogin($login);
    }
}
