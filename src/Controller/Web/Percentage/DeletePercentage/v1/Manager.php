<?php

namespace App\Controller\Web\Percentage\DeletePercentage\v1;

use App\Controller\Web\Percentage\DeletePercentage\v1\Output\DeletedPercentageDTO;
use App\Domain\Entity\Percentage;
use App\Domain\Service\PercentageService;

class Manager
{
    public function __construct(
        private readonly PercentageService $percentageService
    ) {
    }

    public function deletePercentage(Percentage $percentage): DeletedPercentageDTO
    {
        $this->percentageService->removePercentage($percentage);
        return new DeletedPercentageDTO();
    }
}
