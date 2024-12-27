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
     * @param string $lastName
     * @return Student|null
     */
    public function updateLastName(int $studentId, string $lastName): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateLastName($student, $lastName);

        return $student;
    }

    /**
     * @param int $studentId
     * @param string $firstName
     * @return Student|null
     */
    public function updateFirstName(int $studentId, string $firstName): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateFirstName($student, $firstName);

        return $student;
    }

    /**
     * @param int $studentId
     * @param string $middleName
     * @return Student|null
     */
    public function updateMiddleName(int $studentId, string $middleName): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateMiddleName($student, $middleName);

        return $student;
    }

    /**
     * @param int $studentId
     * @param string $phone
     * @return Student|null
     */
    public function updatePhone(int $studentId, string $phone): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updatePhone($student, $phone);

        return $student;
    }

    /**
     * @param int $studentId
     * @param string $email
     * @return Student|null
     */
    public function updateEmail(int $studentId, string $email): ?Student
    {
        $student = $this->studentRepository->find($studentId);
        if (!($student instanceof Student)) {
            return null;
        }
        $this->studentRepository->updateEmail($student, $email);

        return $student;
    }

    /**
     * @param Person $person
     * @return Student
     */
    public function create(Person $person): Student
    {
        $student = new Student();
        $student->changeName(
            $person->getLastName(),
            $person->getFirstName(),
            $person->getMiddleName()
        );
//        $student->setLastName($person->getLastName());
//        $student->setFirstName($person->getFirstName());
//        $student->setMiddleName($person->getMiddleName());
        $student->setEmail($person->getEmail());
        $student->setPhone($person->getPhone());

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
