<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\UnlockedAchievement;

class UnlockedAchievementRepository extends AbstractRepository
{
    /**
     * @param UnlockedAchievement $unlockedAchievement
     * @return int
     */
    public function create(UnlockedAchievement $unlockedAchievement): int
    {
        return $this->store($unlockedAchievement);
    }
}
