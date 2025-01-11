<?php

namespace App\Controller\Web\Skill\GetSkills\v1;

use App\Domain\Entity\Skill;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(private readonly SkillService $skillService)
    {
    }

    /**
     * @return Skill[]
     */
    public function getSkills(?int $page, ?int $perPage): array
    {
        return $this->skillService->getSkills($page, $perPage);
    }
}
