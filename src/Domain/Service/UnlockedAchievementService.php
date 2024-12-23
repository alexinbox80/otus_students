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
     * @param Student $student
     * @param Achievement $achievement
     * @return UnlockedAchievement
     */
    public function give(Student $student, Achievement $achievement): UnlockedAchievement
    {
        $unlockedAchievement = new UnlockedAchievement();
        $unlockedAchievement->setStudent($student);
        $unlockedAchievement->setAchievement($achievement);
        $student->addUnlockedAchievement($unlockedAchievement);
        $achievement->addUnlockedAchievement($unlockedAchievement);

        $this->unlockedAchievementRepository->create($unlockedAchievement);

        return $unlockedAchievement;
    }
}
