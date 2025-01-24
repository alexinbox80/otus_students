<?php

namespace App\Controller\Web\Teacher\CreateTeacher\v1;

use App\Controller\Web\Teacher\CreateTeacher\v1\Input\CreateTeacherDTO;
use App\Controller\Web\Teacher\CreateTeacher\v1\Output\CreatedTeacherDTO;
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
        path: 'api/v1/teacher',
        name: 'web_create_teacher_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateTeacherDTO $createTeacherDTO): CreatedTeacherDTO
    {
        return $this->manager->create($createTeacherDTO);
    }
}
