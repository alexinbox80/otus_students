<?php

namespace App\Controller\Web\Percentage\CreatePercentage\v1;

use App\Controller\Web\Percentage\CreatePercentage\v1\Input\CreatePercentageDTO;
use App\Controller\Web\Percentage\CreatePercentage\v1\Output\CreatedPercentageDTO;
use App\Domain\Model\CreatePercentageModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\PercentageService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreatePercentageModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly PercentageService $percentageService
    ) {
    }

    public function create(CreatePercentageDTO $createPercentageDTO): CreatedPercentageDTO
    {
        $createPercentageModel = $this->modelFactory->makeModel(
            CreatePercentageModel::class,
            $createPercentageDTO->percent,
            $createPercentageDTO->description
        );

        $percentage = $this->percentageService->create($createPercentageModel);

        return new CreatedPercentageDTO(
            $percentage->getId(),
            $percentage->getPercent(),
            $percentage->getDescription(),
            $percentage->getCreatedAt()->format('Y-m-d H:i:s'),
            $percentage->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
