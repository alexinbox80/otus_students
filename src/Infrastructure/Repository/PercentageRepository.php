<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Percentage;
use Doctrine\Common\Collections\Criteria;

class PercentageRepository extends AbstractRepository
{
    /**
     * @return Percentage[]
     */
    public function getPercentages(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('p')
            ->from(Percentage::class, 'p')
            ->orderBy('p.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $percentageId
     * @return Percentage|null
     */
    public function find(int $percentageId): ?Percentage
    {
        $repository = $this->entityManager->getRepository(Percentage::class);
        /** @var Percentage|null $percentage */
        $percentage = $repository->find($percentageId);

        return $percentage;
    }

    /**
     * @return Percentage[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Percentage::class)->findAll();
    }

    /**
     * @param float $percent
     * @return Percentage[]
     */
    public function findPercentagesByPercent(float $percent): array
    {
        return $this->entityManager->getRepository(Percentage::class)->findBy(['percent' => $percent]);
    }

    /**
     * @param string $description
     * @return Percentage[]
     */
    public function findsPercentagesByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Percentage::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Percentage $percentage
     * @param float $percent
     * @return void
     */
    public function updatePercent(Percentage $percentage, float $percent): void
    {
        $percentage->setPercent($percent);
        $this->flush();
    }

    /**
     * @param Percentage $percentage
     * @param string $description
     * @return void
     */
    public function updateDescription(Percentage $percentage, string $description): void
    {
        $percentage->setDescription($description);
        $this->flush();
    }

    /**
     * @param Percentage $percentage
     * @return int
     */
    public function create(Percentage $percentage): int
    {
        return $this->store($percentage);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param Percentage $percentage
     * @return void
     */
    public function remove(Percentage $percentage): void
    {
        $percentage->setDeletedAt();
        $this->flush();
    }
}
