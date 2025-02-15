<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Skill;
use App\Domain\Model\SkillModel;
use Psr\Cache\InvalidArgumentException;

interface SkillRepositoryInterface
{
    /**
     * @param int $page
     * @param int $perPage
     * @return SkillModel[]
     * @throws InvalidArgumentException
     */
    public function getSkillsPaginated(int $page, int $perPage): array;

    /**
     * @param int $skillId
     * @return SkillModel|null
     */
    public function find(int $skillId): ?SkillModel;

    /**
     * @return SkillModel[]
     */
    public function findAll(): array;

    /**
     * @param string $name
     * @return SkillModel[]
     */
    public function findSkillsByName(string $name): array;

    /**
     * @param string $name
     * @return SkillModel[]
     */
    public function findSkillsByNameWithCriteria(string $name): array;

    /**
     * @param string $description
     * @return SkillModel[]
     */
    public function findSkillsByDescriptionWithCriteria(string $description): array;

    /**
     * @param Skill $skill
     * @param string $name
     * @return void
     */
    public function updateName(Skill $skill, string $name): void;

    /**
     * @param Skill $skill
     * @param string $description
     * @return void
     */
    public function updateDescription(Skill $skill, string $description): void;

    /**
     * @param Skill $skill
     * @return int
     */
    public function create(Skill $skill): int;

    /**
     * @return void
     */
    public function update(): void;

    /**
     * @param Skill $skill
     * @return void
     */
    public function remove(Skill $skill): void;
}
