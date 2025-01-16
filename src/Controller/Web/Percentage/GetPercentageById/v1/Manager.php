<?php

namespace App\Controller\Web\Percentage\GetPercentageById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Percentage\GetPercentageById\v1\Output\GotPercentageByIdDTO;
use App\Domain\Service\PercentageService;

class Manager
{
    public function __construct(private readonly PercentageService $percentageService)
    {
    }

    /**
     * @param int $percentageId
     * @return GotPercentageByIdDTO|EmptyDTO
     */
    public function find(int $percentageId): GotPercentageByIdDTO|EmptyDTO
    {
        $percentage = $this->percentageService->find($percentageId);

        if (!is_null($percentage)) {
            return new GotPercentageByIdDTO(
                $percentage->getId(),
                $percentage->getPercent(),
                $percentage->getDescription(),
                $percentage->getCreatedAt()->format('Y-m-d H:i:s'),
                $percentage->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
