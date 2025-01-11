<?php

namespace App\Controller\Web\Task\UpdateTask\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTaskDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min:8)]
        #[Assert\Length(max:128)]
        public readonly string $name,
        #[Assert\Length(min:8)]
        #[Assert\Length(max:255)]
        public readonly ?string $description
    ) {
    }
}
