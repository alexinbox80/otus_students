<?php

namespace App\Controller\Web\Student\GetStudentById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Student\GetStudentById\v1\Output\GotStudentByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-student-by-id/{id}',
        name: 'web_get_student_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotStudentByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}
