<?php

namespace App\Controller\Web\Percentage\GetPercentageById\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class GotPercentageByIdDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly float $percent,
        public readonly ?string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {
    }
}
