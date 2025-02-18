<?php

namespace App\Controller\Web\Student\CreateStudent\v1;

use App\Controller\Web\Student\CreateStudent\v1\Input\CreateStudentDTO;
use App\Controller\Web\Student\CreateStudent\v1\Output\CreatedStudentDTO;
use Psr\Cache\InvalidArgumentException;
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

    /**
     * @throws InvalidArgumentException
     */
    #[Route(
        path: 'api/v1/student',
        name: 'web_create_student_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateStudentDTO $createStudentDTO): CreatedStudentDTO
    {
        return $this->manager->create($createStudentDTO);
    }
}
