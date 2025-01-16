<?php

namespace App\Controller\Web\Achievement\DeleteAchievement\v1;

use App\Controller\Web\Achievement\DeleteAchievement\v1\Output\DeletedAchievementDTO;
use App\Domain\Entity\Achievement;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
        name: 'web_delete_achievement_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Achievement $achievement): DeletedAchievementDTO
    {
        return $this->manager->deleteAchievement($achievement);
    }
}
