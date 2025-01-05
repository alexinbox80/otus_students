<?php

namespace App\Controller\Web\User\GetUserById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\User\GetUserById\v1\Output\GotUserByIdDTO;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param int $userId
     * @return GotUserByIdDTO|EmptyDTO
     */
    public function find(int $userId): GotUserByIdDTO|EmptyDTO
    {
        $user = $this->userService->find($userId);

        if (!is_null($user)) {
            return new GotUserByIdDTO(
                $user->getId(),
                $user->getLogin(),
                $user->getRoles(),
                $user->isActive(),
                $user->getAvatarLink(),
                $user->getCreatedAt()->format('Y-m-d H:i:s'),
                $user->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
