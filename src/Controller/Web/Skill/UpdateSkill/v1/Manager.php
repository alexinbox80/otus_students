<?php

namespace App\Controller\Web\Skill\UpdateSkill\v1;

use App\Controller\Web\Skill\UpdateSkill\v1\Input\UpdateSkillDTO;
use App\Controller\Web\Skill\UpdateSkill\v1\Output\UpdatedSkillDTO;
use App\Domain\Entity\Skill;
use App\Domain\Model\UpdateSkillModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateSkillModel> */
        private readonly ModelFactory $modelFactory,
        private readonly SkillService $skillService
    ) {
    }

    public function updateSkill(Skill $skill, UpdateSkillDTO $updateSkillDTO): UpdatedSkillDTO
    {
        $updateSkillModel = $this->modelFactory->makeModel(
            UpdateSkillModel::class,
            $updateSkillDTO->name,
            $updateSkillDTO->description
        );

        $skill = $this->skillService->update($skill, $updateSkillModel);

        return new UpdatedSkillDTO(
            $skill->id,
            $skill->name,
            $skill->description,
            $skill->createdAt->format('Y-m-d H:i:s'),
            $skill->updatedAt->format('Y-m-d H:i:s')
        );
    }
}
