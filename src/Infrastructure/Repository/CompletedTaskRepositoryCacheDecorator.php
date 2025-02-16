<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\CompletedTask;
use App\Domain\Model\CompletedTaskModel;
use App\Domain\Repository\CompletedTaskRepositoryInterface;
use App\Domain\ValueObject\RedisCacheTagEnum;
use DateTime;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CompletedTaskRepositoryCacheDecorator implements CompletedTaskRepositoryInterface
{
    public function __construct(
        private readonly CompletedTaskRepository $completedTaskRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @param int $completedTaskId
     * @return CompletedTaskModel|null
     */
    public function find(int $completedTaskId): ?CompletedTaskModel
    {
        $completedTask = $this->completedTaskRepository->find($completedTaskId);
        return new CompletedTaskModel(
            $completedTask->getId(),
            $completedTask->getFinishedAt(),
            $completedTask->getDescription(),
            $completedTask->getGrade(),
            $completedTask->getCreatedAt(),
            $completedTask->getUpdatedAt()
        );
    }

    /**
     * @return CompletedTaskModel[]
     */
    public function findAll(): array
    {
        $completedTasks = $this->completedTaskRepository->findAll();

        return array_map(
            static fn (CompletedTask $completedTask): CompletedTaskModel => new CompletedTaskModel(
                $completedTask->getId(),
                $completedTask->getFinishedAt(),
                $completedTask->getDescription(),
                $completedTask->getGrade(),
                $completedTask->getCreatedAt(),
                $completedTask->getUpdatedAt()
            ),
            $completedTasks
        );
    }

    /**
     * @param int $grade
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByGrade(int $grade): array
    {
        $completedTasks = $this->completedTaskRepository->findCompletedTasksByGrade($grade);

        return array_map(
            static fn (CompletedTask $completedTask): CompletedTaskModel => new CompletedTaskModel(
                $completedTask->getId(),
                $completedTask->getFinishedAt(),
                $completedTask->getDescription(),
                $completedTask->getGrade(),
                $completedTask->getCreatedAt(),
                $completedTask->getUpdatedAt()
            ),
            $completedTasks
        );
    }

    /**
     * @param DateTime $finishedAt
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByFinishedAt(DateTime $finishedAt): array
    {
        $completedTasks = $this->completedTaskRepository->findCompletedTasksByFinishedAt($finishedAt);

        return array_map(
            static fn (CompletedTask $completedTask): CompletedTaskModel => new CompletedTaskModel(
                $completedTask->getId(),
                $completedTask->getFinishedAt(),
                $completedTask->getDescription(),
                $completedTask->getGrade(),
                $completedTask->getCreatedAt(),
                $completedTask->getUpdatedAt()
            ),
            $completedTasks
        );
    }

    /**
     * @param string $description
     * @return CompletedTaskModel[]
     */
    public function findCompletedTasksByDescriptionWithCriteria(string $description): array
    {
        $completedTasks = $this->completedTaskRepository->findCompletedTasksByDescriptionWithCriteria($description);

        return array_map(
            static fn (CompletedTask $completedTask): CompletedTaskModel => new CompletedTaskModel(
                $completedTask->getId(),
                $completedTask->getFinishedAt(),
                $completedTask->getDescription(),
                $completedTask->getGrade(),
                $completedTask->getCreatedAt(),
                $completedTask->getUpdatedAt()
            ),
            $completedTasks
        );
    }

    /**
     * @return CompletedTaskModel[]
     * @throws InvalidArgumentException
     */
    public function getCompletedTasksPaginated(int $page, int $perPage): array
    {
        return $this->cache->get(
            $this->getCacheKey($page, $perPage),
            function (ItemInterface $item) use ($page, $perPage) {
                $completedTasks = $this->completedTaskRepository->getCompletedTasksPaginated($page, $perPage);
                $completedTaskModels = array_map(
                    static fn (CompletedTask $completedTask): CompletedTaskModel => new CompletedTaskModel(
                        $completedTask->getId(),
                        $completedTask->getFinishedAt(),
                        $completedTask->getDescription(),
                        $completedTask->getGrade(),
                        $completedTask->getCreatedAt(),
                        $completedTask->getUpdatedAt()
                    ),
                    $completedTasks
                );
                $item->set($completedTaskModels);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value);

                return $completedTaskModels;
            }
        );
    }

    private function getCacheKey(int $page, int $perPage): string
    {
        return RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value . "_{$page}_$perPage";
    }

    /**
     * @param CompletedTask $completedTask
     * @param int $grade
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateGrade(CompletedTask $completedTask, int $grade): void
    {
        $this->completedTaskRepository->updateGrade($completedTask, $grade);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
    }

    /**
     * @param CompletedTask $completedTask
     * @param string $description
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateDescription(CompletedTask $completedTask, string $description): void
    {
        $this->completedTaskRepository->updateDescription($completedTask, $description);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
    }

    /**
     * @param CompletedTask $completedTask
     * @param DateTime $finishedAt
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateFinishedAt(CompletedTask $completedTask, DateTime $finishedAt): void
    {
        $this->completedTaskRepository->updateFinishedAt($completedTask, $finishedAt);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        $this->completedTaskRepository->update();
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
    }

    /**
     * @param CompletedTask $completedTask
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(CompletedTask $completedTask): int
    {
        $result = $this->completedTaskRepository->create($completedTask);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
        return $result;
    }

    /**
     * @param CompletedTask $completedTask
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(CompletedTask $completedTask): void
    {
        $this->completedTaskRepository->remove($completedTask);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_COMPLETED_TASKS->value]);
    }
}
