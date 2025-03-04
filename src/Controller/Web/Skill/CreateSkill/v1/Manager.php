<?php

namespace App\Controller\Web\Skill\CreateSkill\v1;

use App\Controller\Web\Skill\CreateSkill\v1\Input\CreateSkillDTO;
use App\Controller\Web\Skill\CreateSkill\v1\Output\CreatedSkillDTO;
use App\Domain\Model\CreateSkillModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateSkillModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly SkillService $skillService
    ) {
    }

    public function create(CreateSkillDTO $createSkillDTO): CreatedSkillDTO
    {
        $createSkillModel = $this->modelFactory->makeModel(
            CreateSkillModel::class,
            $createSkillDTO->name,
            $createSkillDTO->description
        );

        $skill = $this->skillService->create($createSkillModel);

        return new CreatedSkillDTO(
            $skill->id,
            $skill->name,
            $skill->description,
            $skill->createdAt->format('Y-m-d H:i:s'),
            $skill->updatedAt->format('Y-m-d H:i:s')
        );
    }
}
