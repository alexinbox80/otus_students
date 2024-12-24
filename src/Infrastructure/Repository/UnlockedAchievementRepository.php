<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\UnlockedAchievement;

class UnlockedAchievementRepository extends AbstractRepository
{
    /**
     * @param int $unlockedAchievementId
     * @return UnlockedAchievement|null
     */
    public function find(int $unlockedAchievementId): ?UnlockedAchievement
    {
        $repository = $this->entityManager->getRepository(UnlockedAchievement::class);
        /** @var UnlockedAchievement|null $unlockedAchievement */
        $unlockedAchievement = $repository->find($unlockedAchievementId);

        return $unlockedAchievement;
    }

    /**
     * @return UnlockedAchievement[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(UnlockedAchievement::class)->findAll();
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->flush();
    }

    /**
     * @param UnlockedAchievement $unlockedAchievement
     * @return int
     */
    public function create(UnlockedAchievement $unlockedAchievement): int
    {
        return $this->store($unlockedAchievement);
    }

    /**
     * @param UnlockedAchievement $unlockedAchievement
     * @return void
     */
    public function remove(UnlockedAchievement $unlockedAchievement): void
    {
        $unlockedAchievement->setDeletedAt();
        $this->flush();
    }
}
