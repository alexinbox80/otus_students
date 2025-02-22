<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Person;
use App\Domain\Entity\Teacher;
use App\Domain\Model\TeacherModel;
use App\Domain\Repository\TeacherRepositoryInterface;
use App\Domain\ValueObject\RedisCacheTagEnum;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class TeacherRepositoryCacheDecorator implements TeacherRepositoryInterface
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return TeacherModel[]
     * @throws InvalidArgumentException
     */
    public function getTeachersPaginated(int $page, int $perPage): array
    {
        return $this->cache->get(
            $this->getCacheKey($page, $perPage),
            function (ItemInterface $item) use ($page, $perPage) {
                $teachers = $this->teacherRepository->getTeachersPaginated($page, $perPage);
                $teacherModels = array_map(
                    static fn (Teacher $teacher): TeacherModel => new TeacherModel(
                        $teacher->getId(),
                        $teacher->getUser()->getId(),
                        $teacher->getFirstName(),
                        $teacher->getLastName(),
                        $teacher->getMiddleName(),
                        $teacher->getEmail(),
                        $teacher->getPhone(),
                        $teacher->getCreatedAt(),
                        $teacher->getUpdatedAt()
                    ),
                    $teachers
                );
                $item->set($teacherModels);
                $item->tag(RedisCacheTagEnum::CACHE_TAG_TEACHERS->value);

                return $teacherModels;
            }
        );
    }

    private function getCacheKey(int $page, int $perPage): string
    {
        return RedisCacheTagEnum::CACHE_TAG_STUDENTS->value . "_{$page}_$perPage";
    }

    /**
     * @param int $teacherId
     * @return TeacherModel|null
     */
    public function find(int $teacherId): ?TeacherModel
    {
        $teacher = $this->teacherRepository->find($teacherId);

        if ($teacher !== null)
            return new TeacherModel(
                $teacher->getId(),
                $teacher->getUser()->getId(),
                $teacher->getFirstName(),
                $teacher->getLastName(),
                $teacher->getMiddleName(),
                $teacher->getEmail(),
                $teacher->getPhone(),
                $teacher->getCreatedAt(),
                $teacher->getUpdatedAt()
            );
        else
            return null;
    }

    /**
     * @return TeacherModel[]
     */
    public function findAll(): array
    {
        $teachers = $this->teacherRepository->findAll();

        return array_map(
            static fn (Teacher $teacher): TeacherModel => new TeacherModel(
                $teacher->getId(),
                $teacher->getUser()->getId(),
                $teacher->getFirstName(),
                $teacher->getLastName(),
                $teacher->getMiddleName(),
                $teacher->getEmail(),
                $teacher->getPhone(),
                $teacher->getCreatedAt(),
                $teacher->getUpdatedAt()
            ),
            $teachers
        );
    }

    /**
     * @param string $firstName
     * @return TeacherModel[]
     */
    public function findTeachersByFirstName(string $firstName): array
    {
        $teachers = $this->teacherRepository->findTeachersByFirstName($firstName);

        return array_map(
            static fn (Teacher $teacher): TeacherModel => new TeacherModel(
                $teacher->getId(),
                $teacher->getUser()->getId(),
                $teacher->getFirstName(),
                $teacher->getLastName(),
                $teacher->getMiddleName(),
                $teacher->getEmail(),
                $teacher->getPhone(),
                $teacher->getCreatedAt(),
                $teacher->getUpdatedAt()
            ),
            $teachers
        );
    }

    /**
     * @param string $lastName
     * @return TeacherModel[]
     */
    public function findTeachersByLastName(string $lastName): array
    {
        $teachers = $this->teacherRepository->findTeachersByLastName($lastName);

        return array_map(
            static fn (Teacher $teacher): TeacherModel => new TeacherModel(
                $teacher->getId(),
                $teacher->getUser()->getId(),
                $teacher->getFirstName(),
                $teacher->getLastName(),
                $teacher->getMiddleName(),
                $teacher->getEmail(),
                $teacher->getPhone(),
                $teacher->getCreatedAt(),
                $teacher->getUpdatedAt()
            ),
            $teachers
        );
    }

    /**
     * @param string $middleName
     * @return TeacherModel[]
     */
    public function findTeachersByMiddleName(string $middleName): array
    {
        $teachers = $this->teacherRepository->findTeachersByMiddleName($middleName);

        return array_map(
            static fn (Teacher $teacher): TeacherModel => new TeacherModel(
                $teacher->getId(),
                $teacher->getUser()->getId(),
                $teacher->getFirstName(),
                $teacher->getLastName(),
                $teacher->getMiddleName(),
                $teacher->getEmail(),
                $teacher->getPhone(),
                $teacher->getCreatedAt(),
                $teacher->getUpdatedAt()
            ),
            $teachers
        );
    }

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateName(Teacher $teacher, Person $person): void
    {
        $this->teacherRepository->updateName($teacher, $person);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_TEACHERS->value]);
    }

    /**
     * @param Teacher $teacher
     * @param Person $person
     * @return void
     * @throws InvalidArgumentException
     */
    public function updateContact(Teacher $teacher, Person $person): void
    {
        $this->teacherRepository->updateContact($teacher, $person);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_TEACHERS->value]);
    }

    /**
     * @param Teacher $teacher
     * @return int
     * @throws InvalidArgumentException
     */
    public function create(Teacher $teacher): int
    {
        $result = $this->teacherRepository->create($teacher);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_TEACHERS->value]);

        return $result;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function update(): void
    {
        $this->teacherRepository->update();
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_TEACHERS->value]);
    }

    /**
     * @param Teacher $teacher
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(Teacher $teacher): void
    {
        $this->teacherRepository->remove($teacher);
        $this->cache->invalidateTags([RedisCacheTagEnum::CACHE_TAG_TEACHERS->value]);
    }
}
