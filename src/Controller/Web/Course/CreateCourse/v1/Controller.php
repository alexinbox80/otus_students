<?php

namespace App\Controller\Web\Course\CreateCourse\v1;

use App\Controller\Web\Course\CreateCourse\v1\Input\CreateCourseDTO;
use App\Controller\Web\Course\CreateCourse\v1\Output\CreatedCourseDTO;
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
        path: 'api/v1/course',
        name: 'web_create_course_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateCourseDTO $createCourseDTO): CreatedCourseDTO
    {
        return $this->manager->create($createCourseDTO);
    }
}
