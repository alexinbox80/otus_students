<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Teacher;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Model\UpdateTeacherModel;
use App\Infrastructure\Repository\TeacherRepository;

class TeacherService
{
    public function __construct(private readonly TeacherRepository $teacherRepository)
    {
    }

    /**
     * @param int $teacherId
     * @return ?Teacher
     */
    public function find(int $teacherId): ?Teacher
    {
        return $this->teacherRepository->find($teacherId);
    }

    /**
     * @return Teacher[]
     */
    public function findAll(): array
    {
        return $this->teacherRepository->findAll();
    }

    /**
     * @param string $lastName
     * @return Teacher[]
     */
    public function findTeachersByLastName(string $lastName): array
    {
        return $this->teacherRepository->findTeachersByLastName($lastName);
    }

    /**
     * @param string $firstName
     * @return Teacher[]
     */
    public function findTeachersByFirstName(string $firstName): array
    {
        return $this->teacherRepository->findTeachersByFirstName($firstName);
    }

    /**
     * @param string $middleName
     * @return Teacher[]
     */
    public function findTeachersByMiddleName(string $middleName): array
    {
        return $this->teacherRepository->findTeachersByMiddleName($middleName);
    }

    /**
     * @return Teacher[]
     */
    public function getTeachers(int $page, int $perPage): array
    {
        return $this->teacherRepository->getTeachers($page, $perPage);
    }

    /**
     * @param int $teacherId
     * @param Person $person
     * @return Teacher|null
     */
    public function updateName(int $teacherId, Person $person): ?Teacher
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if (!($teacher instanceof Teacher)) {
            return null;
        }
        $this->teacherRepository->updateName($teacher, $person);

        return $teacher;
    }

    /**
     * @param int $teacherId
     * @param Person $person
     * @return Teacher|null
     */
    public function updateContact(int $teacherId, Person $person): ?Teacher
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if (!($teacher instanceof Teacher)) {
            return null;
        }
        $this->teacherRepository->updateContact($teacher, $person);

        return $teacher;
    }

    /**
     * @param CreateTeacherModel $createTeacherModel
     * @return Teacher
     */
    public function create(CreateTeacherModel $createTeacherModel): Teacher
    {
        $teacher = new Teacher(
            $createTeacherModel->firstName,
            $createTeacherModel->lastName,
            $createTeacherModel->middleName,
            $createTeacherModel->email,
            $createTeacherModel->phone
        );

        $this->teacherRepository->create($teacher);

        return $teacher;
    }

    /**
     * @param Teacher $teacher
     * @param UpdateTeacherModel $updateTeacherModel
     * @return Teacher
     */
    public function update(Teacher $teacher, UpdateTeacherModel $updateTeacherModel): Teacher
    {
        $teacher->changeFields(
            $updateTeacherModel->firstName,
            $updateTeacherModel->lastName,
            $updateTeacherModel->middleName,
            $updateTeacherModel->email,
            $updateTeacherModel->phone
        );

        $this->teacherRepository->update();

        return $teacher;
    }

    /**
     * @param int $teacherId
     * @return void
     */
    public function removeById(int $teacherId): void
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if ($teacher instanceof Teacher) {
            $this->teacherRepository->remove($teacher);
        }
    }

    /**
     * @param Teacher $teacher
     * @return void
     */
    public function removeTeacher(Teacher $teacher): void
    {
        $this->teacherRepository->remove($teacher);
    }
}
