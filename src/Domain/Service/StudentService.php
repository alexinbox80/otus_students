<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Student;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Model\UpdateStudentModel;
use App\Infrastructure\Repository\StudentRepository;

class StudentService
{
    public function __construct(private readonly StudentRepository $studentRepository)
    {
    }

    /**
     * @param int $studentId
     * @return ?Student
     */
    public function find(int $studentId): ?Student
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
     * @return Student[]
     */
    public function getStudents(int $page, int $perPage): array
    {
        return $this->studentRepository->getStudents($page, $perPage);
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
     * @param CreateStudentModel $createStudentModel
     * @return Student
     */
    public function create(CreateStudentModel $createStudentModel): Student
    {
        $student = new Student(
            $createStudentModel->firstName,
            $createStudentModel->lastName,
            $createStudentModel->middleName,
            $createStudentModel->email,
            $createStudentModel->phone
        );

        $this->studentRepository->create($student);

        return $student;
    }

    /**
     * @param Student $student
     * @param UpdateStudentModel $updateStudentModel
     * @return Student
     */
    public function update(Student $student, UpdateStudentModel $updateStudentModel): Student
    {
        $student->changeFields(
            $updateStudentModel->firstName,
            $updateStudentModel->lastName,
            $updateStudentModel->middleName,
            $updateStudentModel->email,
            $updateStudentModel->phone
        );

        $this->studentRepository->update();

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

    /**
     * @param Student $student
     * @return void
     */
    public function removeStudent(Student $student): void
    {
        $this->studentRepository->remove($student);
    }
}
