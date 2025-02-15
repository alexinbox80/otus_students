<?php

namespace App\Controller\Web\Skill\GetSkillsPaginated\v1;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route(
        path: 'api/v1/skills',
        name: 'web_get_skills_v1_invoke',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $perPage = null,
    )
    {
//        return $this->manager->getSkillsPaginated($page ?? 0, $perPage ?? 20);
//        return $this->manager->getSkills($page ?? 0, $perPage ?? 20);
//        return new JsonResponse([
//            'skills' => $this->manager->getSkillsPaginated($page ?? 0, $perPage ?? 20)
//        ]);

        return [
            'skills' => $this->manager->getSkillsPaginated($page ?? 0, $perPage ?? 20)
        ];
    }
}
