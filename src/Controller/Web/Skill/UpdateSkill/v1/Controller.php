<?php

namespace App\Controller\Web\Skill\UpdateSkill\v1;

use App\Controller\Web\Skill\UpdateSkill\v1\Input\UpdateSkillDTO;
use App\Controller\Web\Skill\UpdateSkill\v1\Output\UpdatedSkillDTO;
use App\Domain\Entity\Skill;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/skill/{id}',
        name: 'web_update_skill_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Skill $skill,
        #[MapRequestPayload] UpdateSkillDTO $updateSkillDTO
    ): UpdatedSkillDTO
    {
        return $this->manager->updateSkill($skill, $updateSkillDTO);
    }
}
