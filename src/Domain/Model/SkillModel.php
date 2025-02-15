<?php

namespace App\Domain\Model;

use DateTime;

class SkillModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }
}
