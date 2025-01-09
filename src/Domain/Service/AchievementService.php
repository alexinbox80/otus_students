<?php

namespace App\Domain\Service;

use App\Domain\Entity\Achievement;
use App\Domain\Model\CreateAchievementModel;
use App\Domain\Model\UpdateAchievementModel;
use App\Infrastructure\Repository\AchievementRepository;

class AchievementService
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository
    )
    {
    }

    /**
     * @param int $achievementId
     * @return Achievement
     */
    public function find(int $achievementId): Achievement
    {
        return $this->achievementRepository->find($achievementId);
    }

    /**
     * @return Achievement[]
     */
    public function findAll(): array
    {
        return $this->achievementRepository->findAll();
    }

    /**
     * @return Achievement[]
     */
    public function getAchievements(int $page, int $perPage): array
    {
        return $this->achievementRepository->getAchievements($page, $perPage);
    }

    /**
     * @param string $name
     * @return Achievement[]
     */
    public function findAchievementsByName(string $name): array
    {
        return $this->achievementRepository->findAchievementsByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return Achievement[]
     */
    public function findAchievementsByDescription(string $description): array
    {
        return $this->achievementRepository->findAchievementsByDescriptionWithCriteria($description);
    }

    /**
     * @param int $achievementId
     * @param string $name
     * @return Achievement|null
     */
    public function updateName(int $achievementId, string $name): ?Achievement
    {
        $achievement = $this->achievementRepository->find($achievementId);
        if (!($achievement instanceof Achievement)) {
            return null;
        }
        $this->achievementRepository->updateName($achievement, $name);

        return $achievement;
    }

    /**
     * @param int $achievementId
     * @param string $description
     * @return Achievement|null
     */
    public function updateDescription(int $achievementId, string $description): ?Achievement
    {
        $achievement = $this->achievementRepository->find($achievementId);
        if (!($achievement instanceof Achievement)) {
            return null;
        }
        $this->achievementRepository->updateDescription($achievement, $description);

        return $achievement;
    }

    /**
     * @param Achievement $achievement
     * @param UpdateAchievementModel $updateAchievementModel
     * @return Achievement
     */
    public function update(Achievement $achievement, UpdateAchievementModel $updateAchievementModel): Achievement
    {
        $achievement->changeFields(
            $updateAchievementModel->name,
            $updateAchievementModel->description
        );

        $this->achievementRepository->update();

        return $achievement;
    }

    /**
     * @param CreateAchievementModel $createAchievementModel
     * @return Achievement
     */
    public function create(CreateAchievementModel $createAchievementModel): Achievement
    {
        $achievement = new Achievement(
            $createAchievementModel->name,
            $createAchievementModel->description
        );

        $this->achievementRepository->create($achievement);

        return $achievement;
    }

    /**
     * @param int $achievementId
     * @return void
     */
    public function removeById(int $achievementId): void
    {
        $achievement = $this->achievementRepository->find($achievementId);
        if ($achievement instanceof Achievement) {
            $this->achievementRepository->remove($achievement);
        }
    }

    /**
     * @param Achievement $achievement
     * @return void
     */
    public function removeAchievement(Achievement $achievement): void
    {
        $this->achievementRepository->remove($achievement);
    }
}
