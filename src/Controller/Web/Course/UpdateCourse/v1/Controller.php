<?php

namespace App\Controller\Web\Course\UpdateCourse\v1;

use App\Controller\Web\Course\UpdateCourse\v1\Input\UpdateCourseDTO;
use App\Controller\Web\Course\UpdateCourse\v1\Output\UpdatedCourseDTO;
use App\Domain\Entity\Course;
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
        path: 'api/v1/course/{id}',
        name: 'web_update_course_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Course $course,
        #[MapRequestPayload] UpdateCourseDTO $updateCourseDTO
    ): UpdatedCourseDTO
    {
        return $this->manager->updateCourse($course, $updateCourseDTO);
    }
}
