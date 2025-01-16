<?php

namespace App\Domain\Service;

use App\Domain\Entity\Percentage;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Task;
use App\Domain\Model\CreatePercentageModel;
use App\Domain\Model\UpdatePercentageModel;
use App\Infrastructure\Repository\PercentageRepository;
use Exception;

class PercentageService
{
    public function __construct(
        private readonly PercentageRepository $percentageRepository
    )
    {
    }

    /**
     * @param int $percentageId
     * @return ?Percentage
     */
    public function find(int $percentageId): ?Percentage
    {
        return $this->percentageRepository->find($percentageId);
    }

    /**
     * @return Percentage[]
     */
    public function findAll(): array
    {
        return $this->percentageRepository->findAll();
    }

    /**
     * @param float $percent
     * @return Percentage[]
     */
    public function findPercentagesByPercent(float $percent): array
    {
        return $this->percentageRepository->findPercentagesByPercent($percent);
    }

    /**
     * @param string $description
     * @return Percentage[]
     */
    public function findPercentagesByDescription(string $description): array
    {
        return $this->percentageRepository->findsPercentagesByDescriptionWithCriteria($description);
    }

    /**
     * @return Percentage[]
     */
    public function getPercentages(int $page, int $perPage): array
    {
        return $this->percentageRepository->getPercentages($page, $perPage);
    }

    /**
     * @param int $percentageId
     * @param float $percent
     * @return Percentage|null
     */
    public function updatePercent(int $percentageId, float $percent): ?Percentage
    {
        $percentage = $this->percentageRepository->find($percentageId);
        if (!($percentage instanceof Percentage)) {
            return null;
        }
        $this->percentageRepository->updatePercent($percentage, $percent);

        return $percentage;
    }

    /**
     * @param int $percentageId
     * @param string $description
     * @return Percentage|null
     */
    public function updateDescription(int $percentageId, string $description): ?Percentage
    {
        $percentage = $this->percentageRepository->find($percentageId);
        if (!($percentage instanceof Percentage)) {
            return null;
        }
        $this->percentageRepository->updateDescription($percentage, $description);

        return $percentage;
    }

    /**
     //* @param Task $task
     //* @param Skill $skill
     * @param CreatePercentageModel $createPercentageModel
     * @return Percentage
     */
    public function create(
        //Task $task,
        //Skill $skill,
        CreatePercentageModel $createPercentageModel
    ): Percentage
    {
        $percentage = new Percentage(
            $createPercentageModel->percent,
            $createPercentageModel->description
        );

        //$task->addPercentage($percentage);
        //$skill->addPercentage($percentage);

        $this->percentageRepository->create($percentage);

        return $percentage;
    }

    /**
     * @param Percentage $percentage
     * @param UpdatePercentageModel $updatePercentageModel
     * @return Percentage
     */
    public function update(Percentage $percentage, UpdatePercentageModel $updatePercentageModel): Percentage
    {
        $percentage->changeFields(
            $updatePercentageModel->percent,
            $updatePercentageModel->description
        );

        $this->percentageRepository->update();

        return $percentage;
    }

    /**
     * @param int $percentageId
     * @return void
     */
    public function removeById(int $percentageId): void
    {
        $percentage = $this->percentageRepository->find($percentageId);
        if ($percentage instanceof Percentage) {
            $this->percentageRepository->remove($percentage);
        }
    }

    /**
     * @param Percentage $percentage
     * @return void
     */
    public function removePercentage(Percentage $percentage): void
    {
        $this->percentageRepository->remove($percentage);
    }
}
