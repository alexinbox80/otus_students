<?php

namespace App\Controller\Web\Student\GetStudentById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Student\GetStudentById\v1\Output\GotStudentByIdDTO;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    /**
     * @param int $studentId
     * @return GotStudentByIdDTO|EmptyDTO
     */
    public function find(int $studentId): GotStudentByIdDTO|EmptyDTO
    {
        $student = $this->studentService->find($studentId);

        if (!is_null($student)) {
            return new GotStudentByIdDTO(
                $student->getId(),
                $student->getUser()->getId(),
                $student->getLastName(),
                $student->getFirstName(),
                $student->getMiddleName(),
                $student->getPhone(),
                $student->getEmail(),
                $student->getCreatedAt()->format('Y-m-d H:i:s'),
                $student->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}
