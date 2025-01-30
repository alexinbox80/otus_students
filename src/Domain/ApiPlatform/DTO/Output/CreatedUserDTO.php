<?php

namespace App\Domain\ApiPlatform\DTO\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class CreatedUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        /** @var string[] $roles */
        public readonly array $roles,
        public readonly ?bool $isActive,
        public readonly ?string $avatarLink,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}
