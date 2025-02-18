<?php

namespace App\Controller\Web\Student\DeleteStudent\v1;

use App\Controller\Web\Student\DeleteStudent\v1\Output\DeletedStudentDTO;
use App\Domain\Entity\Student;
use App\Domain\Service\StudentService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(
        private readonly StudentService $studentService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function deleteStudent(Student $student): DeletedStudentDTO
    {
        $this->studentService->removeStudent($student);
        return new DeletedStudentDTO();
    }
}
