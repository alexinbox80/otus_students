<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Student;
use App\Domain\Model\CreateEmailConfirmationCodeModel;
use App\Domain\Model\CreatePhoneConfirmationCodeModel;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Model\StudentModel;
use App\Domain\Model\UpdateStudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use Psr\Cache\InvalidArgumentException;

class StudentService
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly UserService $userService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function confirmationEmail(CreateEmailConfirmationCodeModel $emailConfirmationCodeModel, string $login): bool
    {
        $user = $this->userService->findUserByLogin($login);
        if($user->getStudent()->getEmailCode() !== $emailConfirmationCodeModel->emailCode)
            return false;
        else {
            $user->getStudent()->setEmailConfirmed(true);
            $this->studentRepository->update();
        }

        return true;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function confirmationPhone(CreatePhoneConfirmationCodeModel $phoneConfirmationCodeModel, string $login): bool
    {
        $user = $this->userService->findUserByLogin($login);
        if($user->getStudent()->getPhoneCode() !== $phoneConfirmationCodeModel->phoneCode)
            return false;
        else {
            $user->getStudent()->setPhoneConfirmed(true);
            $this->studentRepository->update();
        }

        return true;
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
     * @return StudentModel[]
     */
    public function findAll(): array
    {
        return $this->studentRepository->findAll();
    }

    /**
     * @param string $lastName
     * @return StudentModel[]
     */
    public function findStudentsByLastName(string $lastName): array
    {
        return $this->studentRepository->findStudentsByLastName($lastName);
    }

    /**
     * @param string $firstName
     * @return StudentModel[]
     */
    public function findStudentsByFirstName(string $firstName): array
    {
        return $this->studentRepository->findStudentsByFirstName($firstName);
    }

    /**
     * @param string $middleName
     * @return StudentModel[]
     */
    public function findStudentsByMiddleName(string $middleName): array
    {
        return $this->studentRepository->findStudentsByMiddleName($middleName);
    }

    /**
     * @return StudentModel[]
     * @throws InvalidArgumentException
     */
    public function getStudentsPaginated(int $page, int $perPage): array
    {
        return $this->studentRepository->getStudentsPaginated($page, $perPage);
    }

    /**
     * @param int $studentId
     * @param Person $person
     * @return StudentModel|null
     * @throws InvalidArgumentException
     */
    public function updateName(int $studentId, Person $person): ?StudentModel
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
     * @return StudentModel|null
     * @throws InvalidArgumentException
     */
    public function updateContact(int $studentId, Person $person): ?StudentModel
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
     * @return StudentModel
     * @throws InvalidArgumentException
     */
    public function create(CreateStudentModel $createStudentModel): StudentModel
    {
        $user = $this->userService->find($createStudentModel->userId);

        $student = new Student(
            $user,
            $createStudentModel->firstName,
            $createStudentModel->lastName,
            $createStudentModel->middleName,
            $createStudentModel->email,
            $createStudentModel->phone
        );
        $student->setEmailCode($createStudentModel->emailCode);
        $student->setPhoneCode($createStudentModel->phoneCode);

        $this->studentRepository->create($student);

        return new StudentModel(
            $student->getId(),
            $student->getUser()->getId(),
            $student->getFirstName(),
            $student->getLastName(),
            $student->getMiddleName(),
            $student->getEmail(),
            $student->getPhone(),
            $student->getCreatedAt(),
            $student->getUpdatedAt()
        );
    }

    /**
     * @param Student $student
     * @param UpdateStudentModel $updateStudentModel
     * @return StudentModel
     * @throws InvalidArgumentException
     */
    public function update(Student $student, UpdateStudentModel $updateStudentModel): StudentModel
    {
        $user = $this->userService->find($updateStudentModel->userId);

        $student->changeFields(
            $user,
            $updateStudentModel->firstName,
            $updateStudentModel->lastName,
            $updateStudentModel->middleName,
            $updateStudentModel->email,
            $updateStudentModel->phone
        );

        $this->studentRepository->update();

        return new StudentModel(
            $student->getId(),
            $student->getUser()->getId(),
            $student->getFirstName(),
            $student->getLastName(),
            $student->getMiddleName(),
            $student->getEmail(),
            $student->getPhone(),
            $student->getCreatedAt(),
            $student->getUpdatedAt()
        );
    }

    /**
     * @param int $studentId
     * @return void
     * @throws InvalidArgumentException
     */
    public function removeById(int $studentId): void
    {
        $student = $this->studentRepository->find($studentId);
        if ($student !== null) {
            $this->studentRepository->remove($student);
        }
    }

    /**
     * @param Student $student
     * @return void
     * @throws InvalidArgumentException
     */
    public function removeStudent(Student $student): void
    {
        $this->studentRepository->remove($student);
    }
}
