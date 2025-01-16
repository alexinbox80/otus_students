<?php

namespace App\Controller\Web\User\UpdateUser\v1;

use App\Controller\Web\User\UpdateUser\v1\Input\UpdateUserDTO;
use App\Controller\Web\User\UpdateUser\v1\Output\UpdatedUserDTO;
use App\Domain\Entity\User;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/user/{id}',
        name: 'web_update_user_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] User $user,
        #[MapRequestPayload] UpdateUserDTO $updateUserDTO
    ): UpdatedUserDTO
    {
        return $this->manager->updateUser($user, $updateUserDTO);
    }
}
