<?php

namespace App\Controller\Web\Skill\GetSkillsPaginated\v1;

use App\Controller\Web\Skill\GetSkillsPaginated\v1\Output\SkillDTO;
use App\Domain\Model\SkillModel;
use App\Domain\Service\SkillService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(
        private readonly SkillService $skillService
    ) {
    }

    /**
     * @return SkillModel[]
     * @throws InvalidArgumentException
     */
    public function getSkillsPaginated(int $page, int $perPage): array
    {
        return array_map(
            static fn (SkillModel $skill) => new SkillDTO(
                $skill->id,
                $skill->name,
                $skill->description,
                $skill->createdAt->format('Y-m-d H:i:s'),
                $skill->updatedAt->format('Y-m-d H:i:s')
            ),
            $this->skillService->getSkillsPaginated($page, $perPage)
        );
    }
}
