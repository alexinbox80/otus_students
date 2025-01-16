<?php

namespace App\Controller\Web\Percentage\UpdatePercentage\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePercentageDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Range(min: 0, max: 100)]
        public readonly float $percent,
        #[Assert\Length(min:8)]
        #[Assert\Length(max:255)]
        public readonly ?string $description
    ) {
    }
}
