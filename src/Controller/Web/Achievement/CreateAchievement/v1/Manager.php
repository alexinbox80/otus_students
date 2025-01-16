<?php

namespace App\Controller\Web\Achievement\CreateAchievement\v1;

use App\Controller\Web\Achievement\CreateAchievement\v1\Input\CreateAchievementDTO;
use App\Controller\Web\Achievement\CreateAchievement\v1\Output\CreatedAchievementDTO;
use App\Domain\Model\CreateAchievementModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\AchievementService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateAchievementModel> */
        private readonly ModelFactory $modelFactory,
        private readonly AchievementService $achievementService,
    ) {
    }

    public function create(CreateAchievementDTO $createAchievementDTO): CreatedAchievementDTO
    {
        $createAchievementModel = $this->modelFactory->makeModel(
            CreateAchievementModel::class,
            $createAchievementDTO->name,
            $createAchievementDTO->description
        );

        $achievement = $this->achievementService->create($createAchievementModel);

        return new CreatedAchievementDTO(
            $achievement->getId(),
            $achievement->getName(),
            $achievement->getDescription(),
            $achievement->getCreatedAt()->format('Y-m-d H:i:s'),
            $achievement->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
