<?php

namespace App\Controller\Web\Percentage\GetPercentages\v1;

use App\Domain\Entity\Percentage;
use App\Domain\Service\PercentageService;

class Manager
{
    public function __construct(private readonly PercentageService $percentageService)
    {
    }

    /**
     * @return Percentage[]
     */
    public function getPercentages(?int $page, ?int $perPage): array
    {
        return $this->percentageService->getPercentages($page, $perPage);
    }
}
