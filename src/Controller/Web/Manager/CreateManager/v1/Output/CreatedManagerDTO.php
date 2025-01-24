<?php

namespace App\Controller\Web\Manager\CreateManager\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class CreatedManagerDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $lastName,
        public readonly string $firstName,
        public readonly ?string $middleName,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {
    }
}
