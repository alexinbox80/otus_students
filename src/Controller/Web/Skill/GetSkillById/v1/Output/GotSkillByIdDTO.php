<?php

namespace App\Controller\Web\Skill\GetSkillById\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class GotSkillByIdDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {
    }
}
