<?php

namespace App\Controller\Web\Course\DeleteCourse\v1;

use App\Controller\Web\Course\DeleteCourse\v1\Output\DeletedCourseDTO;
use App\Domain\Entity\Course;
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
        path: 'api/v1/course/{id}',
        name: 'web_delete_course_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Course $course): DeletedCourseDTO
    {
        return $this->manager->deleteCourse($course);
    }
}
