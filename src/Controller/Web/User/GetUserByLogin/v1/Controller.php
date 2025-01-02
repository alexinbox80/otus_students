<?php

namespace App\Controller\Web\User\GetUserByLogin\v1;

use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        path: '/api/v1/get-user-by-login/{login}',
        name: 'web_get_user_by_login_v1_invoke',
        requirements: ['login' => '\w+'],
        methods: ['GET'],
    )]
    public function __invoke(string $login): JsonResponse
    {
        $users = $this->manager->findUsersByLogin($login);

        if (count($users) === 0) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            array_map(static fn (User $user): array => $user->toArray(), $users),
            Response::HTTP_OK
        );
    }
}
