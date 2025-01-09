<?php

namespace App\Controller\Web\Achievement\CreateAchievement\v1;

use App\Controller\Web\Achievement\CreateAchievement\v1\Input\CreateAchievementDTO;
use App\Controller\Web\Achievement\CreateAchievement\v1\Output\CreatedAchievementDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/achievement',
        name: 'web_create_achievement_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateAchievementDTO $createAchievementDTO): CreatedAchievementDTO
    {
        return $this->manager->create($createAchievementDTO);
    }
}
