<?php

namespace App\Controller\Web\Student\UpdateStudent\v1;

use App\Controller\Web\Student\UpdateStudent\v1\Input\UpdateStudentDTO;
use App\Controller\Web\Student\UpdateStudent\v1\Output\UpdatedStudentDTO;
use App\Domain\Entity\Student;
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
        path: 'api/v1/student/{id}',
        name: 'web_update_student_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Student $student,
        #[MapRequestPayload] UpdateStudentDTO $updateStudentDTO
    ): UpdatedStudentDTO
    {
        return $this->manager->updateStudent($student, $updateStudentDTO);
    }
}
