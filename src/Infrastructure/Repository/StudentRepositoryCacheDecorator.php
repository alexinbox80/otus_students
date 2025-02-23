<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Student;
use App\Domain\Model\StudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use App\Domain\ValueObject\RedisCacheTagEnum;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class StudentRepositoryCacheDecorator implements StudentRepositoryInterface
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @return StudentModel[]
     * @throws InvalidArgumentException
     */
    public function getStudentsPaginated(int $page, int $perPage): array
    {
        return $this->cache->get(
            $this->getCacheKey($page, $perPage),
            function (ItemInterface $item) use ($page, $perPage) {
                $students = $this->studentRepository->getStudentsPaginated($page, $perPage);
                $studentModels = array_map(
                    static fn (Student $student): StudentModel => new StudentModel(
                        $student->getId(),
                        $student->getUser()->getId(),
                        $student->getFirstName(),
                        $student->getLastName(),
                        $student->getMiddleName(),
                        $student->getEmail(),
                        $student->getPhone(),
                        $student->getCreatedAt(),
                        $student->getUpdatedAt()
                    ),
                    $students
                );
                $item->set($studentModels);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_STUDENTS->value);

                return $studentModels;
            }
        );
    }

    private function getCacheKey(int $page, int $perPage): string
    {
        return RedisCacheTagEnum::CACHE_TAG_STUDENTS->value . "_{$page}_$perPage";
    }

    /**
     * @param int $studentId
     * @return Student|null
     */
    public function find(int $studentId): ?Student
    {
        return $this->studentRepository->find($studentId);
    }

    /**
     * @return StudentModel[]
     */
    public function findAll(): array
    {
        $students = $this->studentRepository->findAll();

        return array_map(
            static fn (Student $student): StudentModel => new StudentModel(
                $student->getId(),
                $student->getUser()->getId(),
                $student->getFirstName(),
                $student->getLastName(),
                $student->getMiddleName(),
                $student->getEmail(),
                $student->getPhone(),
                $student->getCreatedAt(),
                $student->getUpdatedAt()
            ),
            $students
        );
    }

    /**
     * @param string $firstName
     * @return StudentModel[]
     */
    public function findStudentsByFirstName(string $firstName): array
    {
        $students = $this->studentRepository->findStudentsByFirstName($firstName);

        return array_map(
            static fn (Student $student): StudentModel => new StudentModel(
                $student->getId(),
                $student->getUser()->getId(),
                $student->getFirstName(),
                $student->getLastName(),
                $student->getMiddleName(),
                $student->getEmail(),
                $student->getPhone(),
                $student->getCreatedAt(),
                $student->getUpdatedAt()
            ),
            $students
        );
    }

    /**
     * @param string $lastName
     * @return StudentModel[]
     */
    public function findStudentsByLastName(string $lastName): array
    {
        $students = $this->studentRepository->findStudentsByLastName($lastName);

        return array_map(
            static fn (Student $student): StudentModel => new StudentModel(
                $student->getId(),
                $student->getUser()->getId(),
                $student->getFirstName(),
                $student->getLastName(),
                $student->getMiddleName(),
                $student->getEmail(),
                $student->getPhone(),
                $student->getCreatedAt(),
                $student->getUpdatedAt()
            ),
            $students
        );
    }

    /**
     * @param string $middleName
     * @return StudentModel[]
     */
    public function findStudentsByMiddleName(string $middleName): array
    {
        $students = $this->studentRepository->findStudentsByMiddleName($middleName);

        return array_map(
            static fn (Student $student): StudentModel => new StudentModel(
                $student->getId(),
                $student->getUser()->getId(),
                $student->getFirstName(),
                $student->getLastName(),
                $student->getMiddleName(),
                $student->getEmail(),
                $student->getPhone(),
                $student->getCreatedAt(),
                $student->getUpdatedAt()
            ),
            $students
        );
    }

    /**
     * @param Student $student
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateName(Student $student, Person $person): void
    {
        $this->studentRepository->updateName($student, $person);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_STUDENTS->value]);
    }

    /**
     * @param Student $student
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateContact(Student $student, Person $person): void
    {
        $this->studentRepository->updateContact($student, $person);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_STUDENTS->value]);
    }

    /**
     * @param Student $student
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Student $student): int
    {
        $result = $this->studentRepository->create($student);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_STUDENTS->value]);
        return $result;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        $this->studentRepository->update();
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_STUDENTS->value]);
    }

    /**
     * @param Student $student
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(Student $student): void
    {
        $this->studentRepository->remove($student);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_STUDENTS->value]);
    }
}
