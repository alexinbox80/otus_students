<?php

namespace App\Controller\Web\Achievement\GetAchievementByName\v1;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: '/api/v1/get-achievement-by-name/{name}',
        name: 'web_get_achievement_by_name_v1_invoke',
        requirements: ['name' => '\w+'],
        methods: ['GET'],
    )]
    public function __invoke(string $name): array
    {
        return $this->manager->findAchievementsByName($name);
    }
}
