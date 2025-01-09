<?php

namespace App\Controller\Web\Achievement\UpdateAchievement\v1;

use App\Controller\Web\Achievement\UpdateAchievement\v1\Input\UpdateAchievementDTO;
use App\Controller\Web\Achievement\UpdateAchievement\v1\Output\UpdatedAchievementDTO;
use App\Domain\Entity\Achievement;
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
        path: 'api/v1/achievement/{id}',
        name: 'web_update_achievement_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Achievement $achievement,
        #[MapRequestPayload] UpdateAchievementDTO $updateAchievementDTO
    ): UpdatedAchievementDTO
    {
        return $this->manager->updateAchievement($achievement, $updateAchievementDTO);
    }
}
