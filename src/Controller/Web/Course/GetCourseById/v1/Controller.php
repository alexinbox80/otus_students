<?php

namespace App\Controller\Web\Course\GetCourseById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Course\GetCourseById\v1\Output\GotCourseByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-course-by-id/{id}',
        name: 'web_get_course_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotCourseByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
