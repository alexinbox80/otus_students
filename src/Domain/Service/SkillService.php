<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Infrastructure\Repository\SkillRepository;

class SkillService
{
    public function __construct(
        private readonly SkillRepository $skillRepository
    )
    {
    }

    /**
     * @param int $skillId
     * @return Skill
     */
    public function find(int $skillId): Skill
    {
        return $this->skillRepository->find($skillId);
    }

    /**
     * @return Skill[]
     */
    public function findAll(): array
    {
        return $this->skillRepository->findAll();
    }

    /**
     * @param string $name
     * @return Skill[]
     */
    public function findSkillsByName(string $name): array
    {
        return $this->skillRepository->findSkillsByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return Skill[]
     */
    public function findSkillsByDescription(string $description): array
    {
        return $this->skillRepository->findSkillsByDescriptionWithCriteria($description);
    }

    /**
     * @param int $skillId
     * @param string $name
     * @return Skill|null
     */
    public function updateName(int $skillId, string $name): ?Skill
    {
        $skill = $this->skillRepository->find($skillId);
        if (!($skill instanceof Skill)) {
            return null;
        }
        $this->skillRepository->updateName($skill, $name);

        return $skill;
    }

    /**
     * @param int $skillId
     * @param string $description
     * @return Skill|null
     */
    public function updateDescription(int $skillId, string $description): ?Skill
    {
        $skill = $this->skillRepository->find($skillId);
        if (!($skill instanceof Skill)) {
            return null;
        }
        $this->skillRepository->updateDescription($skill, $description);

        return $skill;
    }

    /**
     * @param string $name
     * @param string $description
     * @return Skill
     */
    public function create(string $name, string $description): Skill
    {
        $skill = new Skill();
        $skill->setName($name);
        $skill->setDescription($description);
        $this->skillRepository->create($skill);

        return $skill;
    }

    /**
     * @param int $skillId
     * @return void
     */
    public function removeById(int $skillId): void
    {
        $skill = $this->skillRepository->find($skillId);
        if ($skill instanceof Skill) {
            $this->skillRepository->remove($skill);
        }
    }
}
