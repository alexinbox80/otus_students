<?php

namespace App\Controller\Web\Skill\GetSkillById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Skill\GetSkillById\v1\Output\GotSkillByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-skill-by-id/{id}',
        name: 'web_get_skill_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotSkillByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
