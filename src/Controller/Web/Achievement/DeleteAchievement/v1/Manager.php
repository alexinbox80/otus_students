<?php

namespace App\Controller\Web\Achievement\DeleteAchievement\v1;

use App\Controller\Web\Achievement\DeleteAchievement\v1\Output\DeletedAchievementDTO;
use App\Domain\Entity\Achievement;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(
        private readonly AchievementService $achievementService
    ) {
    }

    public function deleteAchievement(Achievement $achievement): DeletedAchievementDTO
    {
        $this->achievementService->removeAchievement($achievement);
        return new DeletedAchievementDTO();
    }
}
