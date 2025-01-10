<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreatePercentageModel
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly float $percent,
        public readonly ?string $description
    ) {
    }
}
