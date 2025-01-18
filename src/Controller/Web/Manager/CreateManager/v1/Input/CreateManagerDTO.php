<?php

namespace App\Controller\Web\Manager\CreateManager\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateManagerDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min:2)]
        #[Assert\Length(max:64)]
        public readonly string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(min:2)]
        #[Assert\Length(max:64)]
        public readonly string $lastName,
        #[Assert\Length(min:2)]
        #[Assert\Length(max:64)]
        public readonly ?string $middleName,
        #[Assert\Email()]
        #[Assert\Length(max:255)]
        public readonly ?string $email,
        #[Assert\Length(min:11)]
        #[Assert\Length(max:16)]
        public readonly ?string $phone
    ) {
    }
}
