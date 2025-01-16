<?php

namespace App\Controller\Web\CompletedTask\CreateCompletedTask\v1\Input;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCompletedTaskDTO
{
    public function __construct(
        #[Assert\Type("\DateTimeInterface")]
        public ?DateTime $finishedAt,
        #[Assert\Length(min:8)]
        #[Assert\Length(max:32)]
        public readonly ?string $description,
        #[Assert\Type('integer')]
        #[Assert\Range(min:1,max:10)]
        public readonly ?int $grade
    ) {
    }
}
