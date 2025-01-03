<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserModel
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $login,
        #[Assert\NotBlank]
        public readonly string $password,
        #[Assert\Type('boolean')]
        public readonly ?bool $isActive
    ) {
    }
}
