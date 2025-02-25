<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Model\CreateSkillModel;
use App\Domain\Model\SkillModel;
use App\Domain\Model\UpdateSkillModel;
use App\Domain\Repository\SkillRepositoryInterface;
use Psr\Cache\InvalidArgumentException;

class SkillService
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository
    ) {
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
     * @return SkillModel[]
     */
    public function findAll(): array
    {
        return $this->skillRepository->findAll();
    }

    /**
     * @param string $name
     * @return SkillModel[]
     */
    public function findSkillsByName(string $name): array
    {
        return $this->skillRepository->findSkillsByNameWithCriteria($name);
    }

    /**
     * @param string $description
     * @return SkillModel[]
     */
    public function findSkillsByDescription(string $description): array
    {
        return $this->skillRepository->findSkillsByDescriptionWithCriteria($description);
    }


    /**
     * @param int $page
     * @param int $perPage
     * @return SkillModel[]
     * @throws InvalidArgumentException
     */
    public function getSkillsPaginated(int $page, int $perPage): array
    {
        return $this->skillRepository->getSkillsPaginated($page, $perPage);
    }

    /**
     * @param int $skillId
     * @param string $name
     * @return SkillModel|null
     */
    public function updateName(int $skillId, string $name): ?SkillModel
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
     * @return SkillModel|null
     */
    public function updateDescription(int $skillId, string $description): ?SkillModel
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
     * @return SkillModel
     */
    public function create(CreateSkillModel $createSkillModel): SkillModel
    {
        $skill = new Skill(
            $createSkillModel->name,
            $createSkillModel->description
        );

        $this->skillRepository->create($skill);

        return new SkillModel(
            $skill->getId(),
            $skill->getName(),
            $skill->getDescription(),
            $skill->getCreatedAt(),
            $skill->getUpdatedAt()
        );
    }

    /**
     * @param Skill $skill
     * @param UpdateSkillModel $updateSkillModel
     * @return SkillModel
     */
    public function update(Skill $skill, UpdateSkillModel $updateSkillModel): SkillModel
    {
        $skill->changeFields(
            $updateSkillModel->name,
            $updateSkillModel->description
        );

        $this->skillRepository->update();

        return new SkillModel(
            $skill->getId(),
            $skill->getName(),
            $skill->getDescription(),
            $skill->getCreatedAt(),
            $skill->getUpdatedAt()
        );
    }

    /**
     * @param int $skillId
     * @return void
     */
    public function removeById(int $skillId): void
    {
        $skill = $this->skillRepository->find($skillId);
        if ($skill !== null) {
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
