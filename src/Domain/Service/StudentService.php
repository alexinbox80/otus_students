<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Student;
use App\Infrastructure\Repository\StudentRepository;

class StudentService
{
    public function __construct(private readonly StudentRepository $studentRepository)
    {
    }

    /**
     * @param int $studentId
     * @return Student
     */
    public function find(int $studentId): Student
    {
        return $this->studentRepository->find($studentId);
    }

    /**
     * @return Student[]
     */
    public function findAll(): array
    {
        return $this->studentRepository->findAll();
    }

    /**
     * @param string $lastName
     * @return Student[]
     */
    public function findStudentsByLastName(string $lastName): array
    {
        return $this->studentRepository->findStudentsByLastName($lastName);
    }

    /**
     * @param string $firstName
     * @return Student[]
     */
    public function findStudentsByFirstName(string $firstName): array
    {
        return $this->studentRepository->findStudentsByFirstName($firstName);
    }

    /**
     * @param string $middleName
     * @return Student[]
     */
    public function findStudentsByMiddleName(string $middleName): array
    {
        return $this->studentRepository->findStudentsByMiddleName($middleName);
    }

    public function create(Person $person): Student
    {
        $student = new Student();
        $student->setLastName($person->getLastName());
        $student->setFirstName($person->getFirstName());
        $student->setMiddleName($person->getMiddleName());
        $student->setEmail($person->getEmail());
        $student->setPhone($person->getPhone());

        $this->studentRepository->create($student);

        return $student;
    }

    public function removeById(int $studentId): void
    {
        $student = $this->studentRepository->find($studentId);
        if ($student instanceof Student) {
            $this->studentRepository->remove($student);
        }
    }
}
