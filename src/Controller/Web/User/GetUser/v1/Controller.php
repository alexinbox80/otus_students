<?php

namespace App\Controller\Web\User\GetUser\v1;

use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/users',
        name: 'web_get_users_v1_invoke',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $perPage = null,
    ): JsonResponse
    {
        $users = $this->manager->getUsers($page ?? 0, $perPage ?? 20);

        return new JsonResponse(
            array_map(static fn (User $user): array => $user->toArray(), $users),
            Response::HTTP_OK
        );
    }
}
