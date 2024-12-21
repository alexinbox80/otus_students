<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
use DateInterval;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;

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
