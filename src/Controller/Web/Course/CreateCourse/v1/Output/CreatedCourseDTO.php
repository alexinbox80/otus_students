<?php

namespace App\Controller\Web\Course\CreateCourse\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class CreatedCourseDTO implements OutputDTOInterface
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
