<?php

namespace App\Controller\Web\Teacher\UpdateTeacher\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class UpdatedTeacherDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
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
