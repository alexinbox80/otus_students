<?php

namespace App\Controller\Web\Student\DeleteStudent\v1;

use App\Controller\Web\Student\DeleteStudent\v1\Output\DeletedStudentDTO;
use App\Domain\Entity\Student;
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
        path: 'api/v1/student/{id}',
        name: 'web_delete_student_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Student $student): DeletedStudentDTO
    {
        return $this->manager->deleteStudent($student);
    }
}
