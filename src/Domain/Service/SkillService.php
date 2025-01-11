<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Model\CreateSkillModel;
use App\Domain\Model\UpdateSkillModel;
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
     * @return ?Skill
     */
    public function find(int $skillId): ?Skill
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
     * @return Skill[]
     */
    public function getSkills(int $page, int $perPage): array
    {
        return $this->skillRepository->getSkills($page, $perPage);
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
     * @param CreateSkillModel $createSkillModel
     * @return Skill
     */
    public function create(CreateSkillModel $createSkillModel): Skill
    {
        $skill = new Skill(
            $createSkillModel->name,
            $createSkillModel->description
        );

        $this->skillRepository->create($skill);

        return $skill;
    }

    /**
     * @param Skill $skill
     * @param UpdateSkillModel $updateSkillModel
     * @return Skill
     */
    public function update(Skill $skill, UpdateSkillModel $updateSkillModel): Skill
    {
        $skill->changeFields(
            $updateSkillModel->name,
            $updateSkillModel->description
        );

        $this->skillRepository->update();

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

    /**
     * @param Skill $skill
     * @return void
     */
    public function removeSkill(Skill $skill): void
    {
        $this->skillRepository->remove($skill);
    }
}
