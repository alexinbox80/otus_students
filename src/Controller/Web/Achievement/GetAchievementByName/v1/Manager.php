<?php

namespace App\Controller\Web\Achievement\GetAchievementByName\v1;

use App\Domain\Entity\Achievement;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(private readonly AchievementService $achievementService)
    {
    }

    /**
     * @param string $name
     * @return Achievement[]
     */
    public function findAchievementsByName(string $name): array
    {
        return $this->achievementService->findAchievementsByName($name);
    }
}
