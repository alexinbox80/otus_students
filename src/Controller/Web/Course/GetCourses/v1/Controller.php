<?php

namespace App\Controller\Web\Course\GetCourses\v1;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/courses',
        name: 'web_get_courses_v1_invoke',
        requirements: ['page' => '\d+', 'perPage' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $page = null,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] ?int $perPage = null,
    ): array
    {
        return $this->manager->getCourses($page ?? 0, $perPage ?? 20);
    }
}
