<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateStudentModel
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $firstName,
        #[Assert\NotBlank]
        public readonly string $lastName,
        public readonly ?string $middleName,
        #[Assert\Email()]
        public readonly ?string $email,
        #[Assert\Type('numeric')]
        public readonly ?string $phone
    ) {
    }
}
