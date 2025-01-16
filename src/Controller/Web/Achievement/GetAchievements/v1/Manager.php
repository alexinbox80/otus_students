<?php

namespace App\Controller\Web\Achievement\GetAchievements\v1;

use App\Domain\Entity\Achievement;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(private readonly AchievementService $achievementService)
    {
    }

    /**
     * @return Achievement[]
     */
    public function getAchievements(?int $page, ?int $perPage): array
    {
        return $this->achievementService->getAchievements($page, $perPage);
    }
}
