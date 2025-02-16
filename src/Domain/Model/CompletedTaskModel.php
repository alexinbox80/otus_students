<?php

namespace App\Domain\Model;

use DateTime;

class CompletedTaskModel
{
    public function __construct(
        public readonly int $id,
        public readonly DateTime $finishedAt,
        public readonly ?string $description,
        public readonly int $grade,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }
}
