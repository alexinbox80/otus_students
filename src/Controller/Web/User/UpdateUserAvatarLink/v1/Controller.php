<?php

namespace App\Controller\Web\User\UpdateUserAvatarLink\v1;

use App\Domain\Entity\User;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: '/api/v1/update-user-avatar-link/{id}',
        name: 'web_update_user_avatar_link_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapEntity(id: 'id')] User $user, Request $request): JsonResponse
    {
        $this->manager->updateUserAvatarLink($user, $request->files->get('image'));

        return new JsonResponse(['user' => $user->toArray()], Response::HTTP_OK);
    }
}
