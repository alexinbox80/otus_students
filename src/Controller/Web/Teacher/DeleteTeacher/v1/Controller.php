<?php

namespace App\Controller\Web\Teacher\DeleteTeacher\v1;

use App\Controller\Web\Teacher\DeleteTeacher\v1\Output\DeletedTeacherDTO;
use App\Domain\Entity\Teacher;
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
        path: 'api/v1/teacher/{id}',
        name: 'web_delete_teacher_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Teacher $teacher): DeletedTeacherDTO
    {
        return $this->manager->deleteTeacher($teacher);
    }
}
