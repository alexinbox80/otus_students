<?php

namespace App\Domain\Model;

use DateTime;

class UpdateCompletedTaskModel
{
    public function __construct(
        public readonly ?DateTime $finishedAt,
        public readonly ?string $description,
        public readonly ?int $grade,
    ) {
    }
}
