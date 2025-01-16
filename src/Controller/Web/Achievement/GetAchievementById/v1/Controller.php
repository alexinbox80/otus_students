<?php

namespace App\Controller\Web\Achievement\GetAchievementById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Achievement\GetAchievementById\v1\Output\GotAchievementByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-achievement-by-id/{id}',
        name: 'web_get_achievement_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotAchievementByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
