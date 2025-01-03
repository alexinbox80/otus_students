<?php

namespace App\Controller\Web\User\DeleteUser\v1;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function deleteUser(User $user): void
    {
        $this->userService->removeUser($user);
    }
}
