<?php

namespace App\Controller\Web\Student\GetStudents\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    /**
     * @return Student[]
     */
    public function getStudents(?int $page, ?int $perPage): array
    {
        return $this->studentService->getStudents($page, $perPage);
    }
}
