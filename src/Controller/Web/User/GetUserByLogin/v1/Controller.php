<?php

namespace App\Controller\Web\User\GetUserByLogin\v1;

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
    public function __invoke(string $login): array
    {
        return $this->manager->findUsersByLogin($login);
    }
}
