<?php

namespace App\Controller\Web\Skill\CreateSkill\v1;

use App\Controller\Web\Skill\CreateSkill\v1\Input\CreateSkillDTO;
use App\Controller\Web\Skill\CreateSkill\v1\Output\CreatedSkillDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/skill',
        name: 'web_create_skill_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateSkillDTO $createSkillDTO): CreatedSkillDTO
    {
        return $this->manager->create($createSkillDTO);
    }
}
