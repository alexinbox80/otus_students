<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateStudentModel
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        #[Assert\NotBlank]
        public readonly string $firstName,
        #[Assert\NotBlank]
        public readonly string $lastName,
        public readonly ?string $middleName = null,
        #[Assert\Email()]
        public readonly ?string $email = null,
        #[Assert\Type('numeric')]
        public readonly ?string $phone = null,
        public readonly ?string $emailCode = null,
        public readonly ?string $phoneCode = null,
    ) {
    }
}
