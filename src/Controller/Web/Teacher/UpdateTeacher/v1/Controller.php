<?php

namespace App\Controller\Web\Teacher\UpdateTeacher\v1;

use App\Controller\Web\Teacher\UpdateTeacher\v1\Input\UpdateTeacherDTO;
use App\Controller\Web\Teacher\UpdateTeacher\v1\Output\UpdatedTeacherDTO;
use App\Domain\Entity\Teacher;
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
        path: 'api/v1/teacher/{id}',
        name: 'web_update_teacher_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Teacher $teacher,
        #[MapRequestPayload] UpdateTeacherDTO $updateTeacherDTO
    ): UpdatedTeacherDTO
    {
        return $this->manager->updateTeacher($teacher, $updateTeacherDTO);
    }
}
