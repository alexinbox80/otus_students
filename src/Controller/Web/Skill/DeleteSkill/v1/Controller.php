<?php

namespace App\Controller\Web\Skill\DeleteSkill\v1;

use App\Controller\Web\Skill\DeleteSkill\v1\Output\DeletedSkillDTO;
use App\Domain\Entity\Skill;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
        name: 'web_delete_skill_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Skill $skill): DeletedSkillDTO
    {
        return $this->manager->deleteSkill($skill);
    }
}
