<?php

namespace App\Controller\Web\Skill\GetSkillsPaginated\v1\Output;

class SkillDTO
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {

    }
}
