<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;

/**
 * @extends AbstractRepository<Student>
 */
class StudentRepository extends AbstractRepository
{
    /**
     * @param int $studentId
     * @return Student|null
     */
    public function find(int $studentId): ?Student
    {
        $repository = $this->entityManager->getRepository(Student::class);
        /** @var Student|null $student */
        $student = $repository->find($studentId);

        return $student;
    }

    /**
     * @return Student[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Student::class)->findAll();
    }

    /**
     * @param string $firstName
     * @return Student[]
     */
    public function findStudentsByFirstName(string $firstName): array
    {
        return $this->entityManager->getRepository(Student::class)->findBy(['firstName' => $firstName]);
    }

    /**
     * @param string $lastName
     * @return Student[]
     */
    public function findStudentsByLastName(string $lastName): array
    {
        return $this->entityManager->getRepository(Student::class)->findBy(['lastName' => $lastName]);
    }

    /**
     * @param string $middleName
     * @return Student[]
     */
    public function findStudentsByMiddleName(string $middleName): array
    {
        return $this->entityManager->getRepository(Student::class)->findBy(['middleName' => $middleName]);
    }

    /**
     * @param Student $student
     * @param string $lastName
     * @return void
     */
    public function updateLastName(Student $student, string $lastName): void
    {
        $student->changeName(lastName: $lastName);
        $this->flush();
    }

    /**
     * @param Student $student
     * @param string $firstName
     * @return void
     */
    public function updateFirstName(Student $student, string $firstName): void
    {
        $student->changeName(firstName: $firstName);
        $this->flush();
    }

    /**
     * @param Student $student
     * @param ?string $middleName
     * @return void
     */
    public function updateMiddleName(Student $student, ?string $middleName): void
    {
        $student->changeName(middleName: $middleName);
        $this->flush();
    }

    /**
     * @param Student $student
     * @param string $phone
     * @return void
     */
    public function updatePhone(Student $student, string $phone): void
    {
        $student->changeContacts(phone: $phone);
        $this->flush();
    }

    /**
     * @param Student $student
     * @param string $email
     * @return void
     */
    public function updateEmail(Student $student, string $email): void
    {
        $student->changeContacts(email: $email);
        $this->flush();
    }

    /**
     * @param Student $student
     * @return int
     */
    public function create(Student $student): int
    {
        return $this->store($student);
    }

    /**
     * @param Student $student
     * @return void
     */
    public function remove(Student $student): void
    {
        $student->setDeletedAt();
        $this->flush();
    }
}
