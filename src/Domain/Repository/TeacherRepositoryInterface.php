<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Teacher;
use App\Domain\Model\TeacherModel;
use Psr\Cache\InvalidArgumentException;

interface TeacherRepositoryInterface
{
    /**
     * @param int $page
     * @param int $perPage
     * @return TeacherModel[]
     * @throws InvalidArgumentException
     */
    public function getTeachersPaginated(int $page, int $perPage): array;

    /**
     * @param int $teacherId
     * @return TeacherModel|null
     */
    public function find(int $teacherId): ?TeacherModel;

    /**
     * @return TeacherModel[]
     */
    public function findAll(): array;

    /**
     * @param string $firstName
     * @return TeacherModel[]
     */
    public function findTeachersByFirstName(string $firstName): array;

    /**
     * @param string $lastName
     * @return TeacherModel[]
     */
    public function findTeachersByLastName(string $lastName): array;

    /**
     * @param string $middleName
     * @return TeacherModel[]
     */
    public function findTeachersByMiddleName(string $middleName): array;

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateName(Teacher $teacher, Person $person): void;

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateContact(Teacher $teacher, Person $person): void;

    /**
     * @param Teacher $teacher
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Teacher $teacher): int;

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void;

    /**
     * @param Teacher $teacher
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(Teacher $teacher): void;
}
