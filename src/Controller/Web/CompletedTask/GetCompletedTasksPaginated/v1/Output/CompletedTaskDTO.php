<?php

namespace App\Controller\Web\CompletedTask\GetCompletedTasksPaginated\v1\Output;

use DateTime;

class CompletedTaskDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $studentId,
        public readonly int $taskId,
        public readonly DateTime $finishedAt,
        public readonly ?string $description,
        public readonly int $grade,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}
