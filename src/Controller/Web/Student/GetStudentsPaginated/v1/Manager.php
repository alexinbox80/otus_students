<?php

namespace App\Controller\Web\Student\GetStudentsPaginated\v1;

use App\Controller\Web\Student\GetStudentsPaginated\v1\Output\StudentDTO;
use App\Domain\Model\StudentModel;
use App\Domain\Service\StudentService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    /**
     * @return StudentModel[]
     * @throws InvalidArgumentException
     */
    public function getStudentsPaginated(?int $page, ?int $perPage): array
    {
        return array_map(
            static fn (StudentModel $student) => new StudentDTO(
                $student->getId(),
                $student->getUserId(),
                $student->getFirstName(),
                $student->getLastName(),
                $student->getMiddleName(),
                $student->getEmail(),
                $student->getPhone(),
                $student->getCreatedAt()->format('Y-m-d H:i:s'),
                $student->getUpdatedAt()->format('Y-m-d H:i:s')
            ),
            $this->studentService->getStudentsPaginated($page, $perPage)
        );
    }
}
