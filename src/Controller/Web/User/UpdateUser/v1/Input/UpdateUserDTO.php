<?php

namespace App\Controller\Web\User\UpdateUser\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDTO
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
        #[Assert\Type('boolean')]
        public readonly ?bool $isActive
    ) {
    }
}
