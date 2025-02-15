<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Skill;
use App\Domain\Model\SkillModel;
use App\Domain\Repository\SkillRepositoryInterface;
use App\Domain\ValueObject\RedisCacheTagEnum;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class SkillRepositoryCacheDecorator implements SkillRepositoryInterface
{
    public function __construct(
        private readonly SkillRepository $skillRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return SkillModel[]
     * @throws InvalidArgumentException
     */
    public function getSkillsPaginated(int $page, int $perPage): array
    {
        return $this->cache->get(
            $this->getCacheKey($page, $perPage),
            function (ItemInterface $item) use ($page, $perPage) {
                $skills = $this->skillRepository->getskillsPaginated($page, $perPage);
                $skillModels = array_map(
                    static fn (Skill $skill): SkillModel => new SkillModel(
                        $skill->getId(),
                        $skill->getName(),
                        $skill->getDescription(),
                        $skill->getCreatedAt(),
                        $skill->getUpdatedAt(),
                    ),
                    $skills
                );
                $item->set($skillModels);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_SKILLS->value);

                return $skillModels;
            }
        );
    }

    private function getCacheKey(int $page, int $perPage): string
    {
        return RedisCacheTagEnum::CACHE_TAG_SKILLS->value . "_{$page}_$perPage";
    }

    /**
     * @param int $skillId
     * @return SkillModel|null
     */
    public function find(int $skillId): ?SkillModel
    {
        $skill = $this->skillRepository->find($skillId);
        if ($skill !== null) {
            return new SkillModel(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt(),
                $skill->getUpdatedAt()
            );
        } else
            return null;
    }

    /**
     * @return SkillModel[]
     */
    public function findAll(): array
    {
        $skills =  $this->skillRepository->findAll();

        return array_map(
            static fn (Skill $skill): SkillModel => new SkillModel(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt(),
                $skill->getUpdatedAt(),
            ),
            $skills
        );
    }

    /**
     * @param string $name
     * @return SkillModel[]
     */
    public function findSkillsByName(string $name): array
    {
        $skills = $this->skillRepository->findSkillsByName($name);

        return array_map(
            static fn (Skill $skill): SkillModel => new SkillModel(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt(),
                $skill->getUpdatedAt(),
            ),
            $skills
        );
    }

    /**
     * @param string $name
     * @return SkillModel[]
     */
    public function findSkillsByNameWithCriteria(string $name): array
    {
        $skills = $this->skillRepository->findSkillsByDescriptionWithCriteria($name);

        return array_map(
            static fn (Skill $skill): SkillModel => new SkillModel(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt(),
                $skill->getUpdatedAt(),
            ),
            $skills
        );
    }

    /**
     * @param string $description
     * @return SkillModel[]
     */
    public function findSkillsByDescriptionWithCriteria(string $description): array
    {
        $skills = $this->skillRepository->findSkillsByDescriptionWithCriteria($description);

        return array_map(
            static fn (Skill $skill): SkillModel => new SkillModel(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt(),
                $skill->getUpdatedAt(),
            ),
            $skills
        );
    }

    /**
     * @param Skill $skill
     * @param string $name
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateName(Skill $skill, string $name): void
    {
        $this->skillRepository->updateName($skill, $name);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_SKILLS->value]);
    }

    /**
     * @param Skill $skill
     * @param string $description
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateDescription(Skill $skill, string $description): void
    {
        $this->skillRepository->updateDescription($skill, $description);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_SKILLS->value]);
    }

    /**
     * @param Skill $skill
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Skill $skill): int
    {
        $result = $this->skillRepository->create($skill);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_SKILLS->value]);

        return $result;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        $this->skillRepository->update();
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_SKILLS->value]);
    }

    /**
     * @param Skill $skill
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(Skill $skill): void
    {
        $this->skillRepository->remove($skill);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_SKILLS->value]);
    }
}
