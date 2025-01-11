<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Skill;
use Doctrine\Common\Collections\Criteria;

class SkillRepository extends AbstractRepository
{
    /**
     * @return Skill[]
     */
    public function getSkills(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')
            ->from(Skill::class, 's')
            ->orderBy('s.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $skillId
     * @return Skill|null
     */
    public function find(int $skillId): ?Skill
    {
        $repository = $this->entityManager->getRepository(Skill::class);
        /** @var Skill|null $skill */
        $skill = $repository->find($skillId);

        return $skill;
    }

    /**
     * @return Skill[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Skill::class)->findAll();
    }

    /**
     * @param string $name
     * @return Skill[]
     */
    public function findSkillsByName(string $name): array
    {
        return $this->entityManager->getRepository(Skill::class)->findBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Skill[]
     */
    public function findSkillsByNameWithCriteria(string $name): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('name', $name));
        $repository = $this->entityManager->getRepository(Skill::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param string $description
     * @return Skill[]
     */
    public function findSkillsByDescriptionWithCriteria(string $description): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->contains('description', $description));
        $repository = $this->entityManager->getRepository(Skill::class);

        return $repository->matching($criteria)->toArray();
    }

    /**
     * @param Skill $skill
     * @param string $name
     * @return void
     */
    public function updateName(Skill $skill, string $name): void
    {
        $skill->setName($name);
        $this->flush();
    }

    /**
     * @param Skill $skill
     * @param string $description
     * @return void
     */
    public function updateDescription(Skill $skill, string $description): void
    {
        $skill->setDescription($description);
        $this->flush();
    }

    /**
     * @param Skill $skill
     * @return int
     */
    public function create(Skill $skill): int
    {
        return $this->store($skill);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param Skill $skill
     * @return void
     */
    public function remove(Skill $skill): void
    {
        $skill->setDeletedAt();
        $this->flush();
    }
}
