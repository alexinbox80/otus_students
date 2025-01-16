<?php

namespace App\Controller\Web\User\UpdateUserAvatarLink\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class UpdatedUserAvatarDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly ?string $avatarLink,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}
