<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Teacher;

/**
 * @extends AbstractRepository<Teacher>
 */
class TeacherRepository extends AbstractRepository
{
    /**
     * @return Teacher[]
     */
    public function getTeachers(int $page, int $perPage): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('t')
            ->from(Teacher::class, 't')
            ->orderBy('t.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $teacherId
     * @return Teacher|null
     */
    public function find(int $teacherId): ?Teacher
    {
        $repository = $this->entityManager->getRepository(Teacher::class);
        /** @var Teacher|null $teacher */
        $teacher = $repository->find($teacherId);

        return $teacher;
    }

    /**
     * @return Teacher[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findAll();
    }

    /**
     * @param string $firstName
     * @return Teacher[]
     */
    public function findTeachersByFirstName(string $firstName): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findBy(['firstName' => $firstName]);
    }

    /**
     * @param string $lastName
     * @return Teacher[]
     */
    public function findTeachersByLastName(string $lastName): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findBy(['lastName' => $lastName]);
    }

    /**
     * @param string $middleName
     * @return Teacher[]
     */
    public function findTeachersByMiddleName(string $middleName): array
    {
        return $this->entityManager->getRepository(Teacher::class)->findBy(['middleName' => $middleName]);
    }

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     */
    public function updateName(Teacher $teacher, Person $person): void
    {
        $teacher->changeName(
            $person->getFirstName(),
            $person->getLastName(),
            $person->getMiddleName()
        );
        $this->flush();
    }

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     */
    public function updateContact(Teacher $teacher, Person $person): void
    {
        $teacher->changeContacts(
            $person->getEmail(),
            $person->getPhone()
        );
        $this->flush();
    }

    /**
     * @param Teacher $teacher
     * @return int
     */
    public function create(Teacher $teacher): int
    {
        return $this->store($teacher);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->flush();
    }

    /**
     * @param Teacher $teacher
     * @return void
     */
    public function remove(Teacher $teacher): void
    {
        $teacher->setDeletedAt();
        $this->flush();
    }
}
