<?php

namespace App\Controller\Web\Achievement\GetAchievementById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Achievement\GetAchievementById\v1\Output\GotAchievementByIdDTO;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(private readonly AchievementService $achievementService)
    {
    }

    /**
     * @param int $achievementId
     * @return GotAchievementByIdDTO|EmptyDTO
     */
    public function find(int $achievementId): GotAchievementByIdDTO|EmptyDTO
    {
        $achievement = $this->achievementService->find($achievementId);

        if (!is_null($achievement)) {
            return new GotAchievementByIdDTO(
                $achievement->getId(),
                $achievement->getName(),
                $achievement->getDescription(),
                $achievement->getCreatedAt()->format('Y-m-d H:i:s'),
                $achievement->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
