<?php

namespace App\Controller\Web\Token\GetToken\v1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager) {
    }

    #[Route(
        path: 'api/v1/get-token',
        name: 'web_get_token_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(Request $request): array
    {
        return ['token' => $this->manager->getToken($request)];
    }
}
