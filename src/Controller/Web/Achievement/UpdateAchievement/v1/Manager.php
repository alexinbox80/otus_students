<?php

namespace App\Controller\Web\Achievement\UpdateAchievement\v1;

use App\Controller\Web\Achievement\UpdateAchievement\v1\Input\UpdateAchievementDTO;
use App\Controller\Web\Achievement\UpdateAchievement\v1\Output\UpdatedAchievementDTO;
use App\Domain\Entity\Achievement;
use App\Domain\Model\UpdateAchievementModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateAchievementModel> */
        private readonly ModelFactory $modelFactory,
        private readonly AchievementService $achievementService
    ) {
    }

    public function updateAchievement(Achievement $achievement, UpdateAchievementDTO $updateAchievementDTO): UpdatedAchievementDTO
    {
        $updateAchievementModel = $this->modelFactory->makeModel(
            UpdateAchievementModel::class,
            $updateAchievementDTO->name,
            $updateAchievementDTO->description
        );

        $achievement = $this->achievementService->update($achievement, $updateAchievementModel);

        return new UpdatedAchievementDTO(
            $achievement->getId(),
            $achievement->getName(),
            $achievement->getDescription(),
            $achievement->getCreatedAt()->format('Y-m-d H:i:s'),
            $achievement->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
