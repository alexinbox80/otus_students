<?php

namespace App\Controller\Web\Skill\GetSkillById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Skill\GetSkillById\v1\Output\GotSkillByIdDTO;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(private readonly SkillService $skillService)
    {
    }

    /**
     * @param int $skillId
     * @return GotSkillByIdDTO|EmptyDTO
     */
    public function find(int $skillId): GotSkillByIdDTO|EmptyDTO
    {
        $skill = $this->skillService->find($skillId);

        if (!is_null($skill)) {
            return new GotSkillByIdDTO(
                $skill->getId(),
                $skill->getName(),
                $skill->getDescription(),
                $skill->getCreatedAt()->format('Y-m-d H:i:s'),
                $skill->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
