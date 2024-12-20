<?php

namespace App\Domain\Service;

use App\Domain\Entity\Student;
use App\Infrastructure\Repository\StudentRepository;

class StudentService
{
    public function __construct(private readonly StudentRepository $studentRepository)
    {
    }

    public function create(string $lastName, string $firstName, string $middleName): Student
    {
        $student = new Student();
        $student->setLastName($lastName);
        $student->setFirstName($firstName);
        $student->setMiddleName($middleName);
        $this->studentRepository->create($student);

        return $student;
    }
}
