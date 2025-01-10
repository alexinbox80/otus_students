<?php

namespace App\Controller\Web\Lesson\CreateLesson\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class CreatedLessonDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}
