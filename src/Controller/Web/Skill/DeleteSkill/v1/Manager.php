<?php

namespace App\Controller\Web\Skill\DeleteSkill\v1;

use App\Controller\Web\Skill\DeleteSkill\v1\Output\DeletedSkillDTO;
use App\Domain\Entity\Skill;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        private readonly SkillService $skillService
    ) {
    }

    public function deleteSkill(Skill $skill): DeletedSkillDTO
    {
        $this->skillService->removeSkill($skill);
        return new DeletedSkillDTO();
    }
}
