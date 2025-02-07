<?php

namespace App\Domain\ApiPlatform\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min:6)]
        #[Assert\Length(max:32)]
        public readonly string $login,
        #[Assert\NotBlank]
        #[Assert\Length(min:8)]
        #[Assert\Length(max:32)]
        public readonly string $password,
        #[Assert\NotNull]
        #[Assert\Type('boolean')]
        public readonly ?bool $isActive,
        public readonly array $roles
    ) {
    }
}
