<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Achievement;
use Doctrine\Common\Collections\Criteria;

class AchievementRepository extends AbstractRepository
{
    /**
     * @param int $achievementId
     * @return Achievement|null
     */
    public function find(int $achievementId): ?Achievement
    {
        $repository = $this->entityManager->getRepository(Achievement::class);
        /** @var Achievement|null $achievement */
        $achievement = $repository->find($achievementId);

        return $achievement;
    }

    /**
     * @return Achievement[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Achievement::class)->findAll();
    }

    /**
     * @param string $name
     * @return Achievement[]
     */
    public function findAchievementsByName(string $name): array
    {
        return $this->entityManager->getRepository(Achievement::class)->findBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Achievement[]
     */
    public function findAchievementsByNameWithCriteria(string $name): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('name', $name));
        $repository = $this->entityManager->getRepository(Achievement::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param string $description
     * @return Achievement[]
     */
    public function findAchievementsByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Achievement::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Achievement $achievement
     * @param string $name
     * @return void
     */
    public function updateName(Achievement $achievement, string $name): void
    {
        $achievement->setName($name);
        $this->flush();
    }

    /**
     * @param Achievement $achievement
     * @param string $description
     * @return void
     */
    public function updateDescription(Achievement $achievement, string $description): void
    {
        $achievement->setDescription($description);
        $this->flush();
    }

    /**
     * @param Achievement $achievement
     * @return int
     */
    public function create(Achievement $achievement): int
    {
        return $this->store($achievement);
    }

    /**
     * @param Achievement $achievement
     * @return void
     */
    public function remove(Achievement $achievement): void
    {
        $achievement->setDeletedAt();
        $this->flush();
    }
}
