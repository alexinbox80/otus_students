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

    /**
     * @param int $studentId
     * @param Person $person
     * @return Student|null
     */
    public function updateName(int $studentId, Person $person): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateName($student, $person);

        return $student;
    }

    /**
     * @param int $studentId
     * @param Person $person
     * @return Student|null
     */
    public function updateContact(int $studentId, Person $person): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateContact($student, $person);

        return $student;
    }

    /**
     * @param Person $person
     * @return Student
     */
    public function create(Person $person): Student
    {
        $student = new Student(
            $person->getLastName(),
            $person->getFirstName(),
            $person->getMiddleName(),
            $person->getEmail(),
            $person->getPhone()
        );

        $this->studentRepository->create($student);

        return $student;
    }

    /**
     * @param int $studentId
     * @return void
     */
    public function removeById(int $studentId): void
    {
        $student = $this->studentRepository->find($studentId);
        if ($student instanceof Student) {
            $this->studentRepository->remove($student);
        }
    }
}
