<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Student;
use App\Domain\Model\StudentModel;
use Psr\Cache\InvalidArgumentException;

interface StudentRepositoryInterface
{
    /**
     * @return StudentModel[]
     * @throws InvalidArgumentException
     */
    public function getStudentsPaginated(int $page, int $perPage): array;

    /**
     * @param int $studentId
     * @return Student|null
     */
    public function find(int $studentId): ?Student;

    /**
     * @return StudentModel[]
     */
    public function findAll(): array;

    /**
     * @param string $firstName
     * @return StudentModel[]
     */
    public function findStudentsByFirstName(string $firstName): array;

    /**
     * @param string $lastName
     * @return StudentModel[]
     */
    public function findStudentsByLastName(string $lastName): array;

    /**
     * @param string $middleName
     * @return StudentModel[]
     */
    public function findStudentsByMiddleName(string $middleName): array;

    /**
     * @param Student $student
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateName(Student $student, Person $person): void;

    /**
     * @param Student $student
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateContact(Student $student, Person $person): void;

    /**
     * @param Student $student
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Student $student): int;

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void;

    /**
     * @param Student $student
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(Student $student): void;
}
