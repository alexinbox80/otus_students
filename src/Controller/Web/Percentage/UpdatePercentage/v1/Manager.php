<?php

namespace App\Controller\Web\Percentage\UpdatePercentage\v1;

use App\Controller\Web\Percentage\UpdatePercentage\v1\Input\UpdatePercentageDTO;
use App\Controller\Web\Percentage\UpdatePercentage\v1\Output\UpdatedPercentageDTO;
use App\Domain\Entity\Percentage;
use App\Domain\Model\UpdatePercentageModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\PercentageService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdatePercentageModel> */
        private readonly ModelFactory $modelFactory,
        private readonly PercentageService $percentageService
    ) {
    }

    public function updatePercentage(Percentage $percentage, UpdatePercentageDTO $updatePercentageDTO): UpdatedPercentageDTO
    {
        $updatePercentageModel = $this->modelFactory->makeModel(
            UpdatePercentageModel::class,
            $updatePercentageDTO->percent,
            $updatePercentageDTO->description
        );

        $percentage = $this->percentageService->update($percentage, $updatePercentageModel);

        return new UpdatedPercentageDTO(
            $percentage->getId(),
            $percentage->getPercent(),
            $percentage->getDescription(),
            $percentage->getCreatedAt()->format('Y-m-d H:i:s'),
            $percentage->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
