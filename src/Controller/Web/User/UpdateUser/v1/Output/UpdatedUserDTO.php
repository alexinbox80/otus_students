<?php

namespace App\Controller\Web\User\UpdateUser\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

class UpdatedUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly array $roles,
        public readonly ?bool $isActive,
        public readonly ?string $avatarLink,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}