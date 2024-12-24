<?php

namespace App\Domain\Service;

use App\Domain\Entity\Achievement;
use App\Domain\Entity\Student;
use App\Domain\Entity\UnlockedAchievement;
use App\Infrastructure\Repository\UnlockedAchievementRepository;

class UnlockedAchievementService
{
    public function __construct(
        private readonly UnlockedAchievementRepository $unlockedAchievementRepository
    )
    {
    }

    /**
     * @param int $unlockedAchievementId
     * @return UnlockedAchievement
     */
    public function find(int $unlockedAchievementId): UnlockedAchievement
    {
        return $this->unlockedAchievementRepository->find($unlockedAchievementId);
    }

    /**
     * @return UnlockedAchievement[]
     */
    public function findAll(): array
    {
        return $this->unlockedAchievementRepository->findAll();
    }

    /**
     * @param Student $student
     * @param Achievement $achievement
     * @return UnlockedAchievement
     */
    public function create(Student $student, Achievement $achievement): UnlockedAchievement
    {
        $unlockedAchievement = new UnlockedAchievement();
        $unlockedAchievement->setStudent($student);
        $unlockedAchievement->setAchievement($achievement);
        $student->addUnlockedAchievement($unlockedAchievement);
        $achievement->addUnlockedAchievement($unlockedAchievement);

        $this->unlockedAchievementRepository->create($unlockedAchievement);

        return $unlockedAchievement;
    }

    /**
     * @param Student $student
     * @param Achievement $achievement
     * @return UnlockedAchievement
     */
    public function changeUnlockedAchievement(Student $student, Achievement $achievement): UnlockedAchievement
    {
        $unlockedAchievement = new UnlockedAchievement();
        $unlockedAchievement->setStudent($student);
        $unlockedAchievement->setAchievement($achievement);
        $this->unlockedAchievementRepository->flush();

        return $unlockedAchievement;
    }

    /**
     * @param int $unlockedAchievementId
     * @return void
     */
    public function removeById(int $unlockedAchievementId): void
    {
        $unlockedAchievement = $this->unlockedAchievementRepository->find($unlockedAchievementId);
        if ($unlockedAchievement instanceof UnlockedAchievement) {
            $this->unlockedAchievementRepository->remove($unlockedAchievement);
        }
    }
}
