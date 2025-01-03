<?php

namespace App\Controller\Web\User\CreateUser\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max:32)]
        public readonly string $login,
        #[Assert\NotBlank]
        #[Assert\Length(max:32)]
        public readonly string $password,
        #[Assert\Type('boolean')]
        public readonly ?bool $isActive
    ) {
    }
}
