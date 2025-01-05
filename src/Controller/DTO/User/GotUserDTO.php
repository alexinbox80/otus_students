<?php

namespace App\Controller\DTO\User;

use App\Controller\DTO\Interfaces\OutputDTOInterface;
use DateTime;

class GotUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly array $roles,
        public readonly bool $isActive,
        public readonly ?string $avatarLink,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }
}
